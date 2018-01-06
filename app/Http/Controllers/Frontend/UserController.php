<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Entities\Author;
use App\Entities\Book;
use App\Entities\User;
use App\Notifications\TaskCompleted;
use function base64_encode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;
use function json_encode;
use Mockery\Exception;
use function print_r;
use App\Events\AcceptGiveBookEvent;
class UserController extends Controller
{
	/**
	 * [receive description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function receive(Request $request)
	{
		try{
			$user = Auth::user();
			$book_id = $request->book_id;
			if ($user && $book_id){
				$book = Book::where('id' , '=' , $book_id)->first();
				if ($book){
					if($book->quantity > 0){
						$user->setReceiver()->save($book);
						return response()->json(array('status' => 1,'msg' => 'Yêu cầu nhận sách '. $book->name. ' thành công. <br> Bạn hãy chờ xác nhận của người tặng nha ^^'));
					}else{
						return response()->json(array('status' => -1,'msg' => 'Sách '. $book->name. ' đã tặng hết rồi'));
					}
				}else{
					return response()->json(array('status' => -1,'msg' => 'Sách '. $book->name. ' không có trong kho sách, hoặc bị xóa.'));
				}
			}else{
				return response()->json(array('status' => -1,'msg' => 'Bạn chưa đăng nhập, vui lòng đăng nhập để nhận sách nha'));
			}
		}catch (Exception $e){
			return response()->json($e->getMessage());
		}
	}

	function getMyGiven(Request $request){
		try{
			$user = Auth::guard()->user();

			if ($user){
				$params = $request->all();
				$limit = isset($params['limit'])?$params['limit']:12;
				$books = $user->giveBook()->paginate($limit);

				return response()->json($books);
			}else{
				return response()->json(array('status' => -1, 'msg' => 'Login again'));
			}
		}catch (Exception $e){
			return response()->json($e->getMessage());
		}
	}

	function getMyRequest(Request $request){
		try{
			$user = Auth::guard()->user();
			if ($user){
				$params = $request->all();
				$limit = isset($params['limit'])?$params['limit']:12;
				$books = $user->bookRequest()->paginate($limit);
				return response()->json($books);
			}else{
				return response()->json(array('status' => -1, 'msg' => 'Login again'));
			}
		}catch (Exception $e){
			$e->getMessage();
		}
	}
	function getBookByReceive(Request $request){
		try{
			$user = Auth::guard()->user();
			if ($user){
				$params = $request->all();
				$limit = isset($params['limit'])?$params['limit']:12;
				$books = $user->has('receiver')->with('receiver')->paginate($limit);
				return response()->json($books);
			}else{
				return response()->json(array('status' => -1, 'msg' => 'Login again'));
			}
		}catch (Exception $e){
			return response()->json($e->getMessage());
		}
	}

	function getBookByReceived(Request $request){
		try{
			$user = Auth::guard()->user();
			if ($user){
				$params = $request->all();
				$limit = isset($params['limit'])?$params['limit']:12;
				$books = $user->received()->paginate($limit);
				return $books;
				return response()->json($books);
			}else{
				return response()->json(array('status' => -1, 'msg' => 'Login again'));
			}
		}catch (Exception $e){
			return response()->json($e->getMessage());
		}
	}

	/**
	 * [cancelGiveBook description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	function cancelGiveBook(Request $request){
		try{
			$user = Auth::guard()->user();
			$book_id = $request->get('book_id');
			$quantity = $request->get('quantity');
			$receiver_id = $request->get('receiver_id');

			if ($user && $book_id){
				DB::beginTransaction();
				$book = Book::where('id','=',$book_id)->first();

				$receiver = User::where('id','=',$receiver_id)->first();
				if ($book['quantity'] > 0){

					$result = Curl::to("http://localhost:7474/db/data/cypher")
					->withData(json_encode(
						array(
							'query' => "match(user:User { fb_user_id : {userID} })-[r:NEED_BOOK]-(book:Book { title : {bookTitle} }) detach delete r",
							"params" => array(
								"userID" => $receiver->fb_user_id,
								"bookTitle" => $book->title
							)
						)
					)
				)
					->withHeader('Accept:application/json')
					->withHeader('Content-Type:application/json')
					->withHeader('Authorization: Basic '.base64_encode('truonganh:loveparadise1'))
					->post();
					DB::commit();
					$user->notify(new TaskCompleted(array('title' => $user['name'].' cancel give book '.$book['title']))
				);
					return response()->json(array('status' => 200, 'msg' => 'Hủy tặng sách thành công'));
				}else{
					return response()->json(array('status' => 404, 'msg' => $e->getMessage()));
				}

			}else{
				return response()->json(array('status' => -1, 'msg' => 'Login again'));
			}
		}catch (Exception $e){
			DB::rollback();
			return response()->json($e->getMessage());
		}catch(\Everyman\Neo4j\Exception $e){
			DB::rollback();
			return response()->json($e->getMessage());
		}
	}

	/**
	 * [acceptGiveBook description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	function acceptGiveBook(Request $request){
		try{
			$user = Auth::guard()->user();
			event(new AcceptGiveBookEvent($user));

			$book_id = $request->get('book_id');
			$quantity = $request->get('quantity');
			$receiver_id = $request->get('receiver_id');

			if ($user && $book_id){
				$book = Book::where('id','=',$book_id)->first();

				$receiver = User::where('id','=',$receiver_id)->first();
				if ($book['quantity'] > 0){
					if ($book['quantity'] == 1){
						dd($receiver->getRelation());
						$receiver->hasBook()->save($book);
						return response()->json(array('status' => 200, 'msg' => 'Tặng sách thành công'));
					}else{
						$result = Curl::to("http://localhost:7474/db/data/cypher")
						->withData(
							json_encode(
								array(
									'query' => "match(user:User { fb_user_id : {userID} })-[r:NEED_BOOK]-(book:Book { title : {bookTitle} }) detach delete r",
									"params" => array(
										"userID" => $receiver->fb_user_id,
										"bookTitle" => $book->title
									)
								)
							)
						)
						->withHeader('Accept:application/json')
						->withHeader('Content-Type:application/json')
						->withHeader('Authorization: Basic '.base64_encode('truonganh:loveparadise1'))
						->post();
						DB::beginTransaction();
						$newBook = Book::create(array(
							'title' => $book->title,
							'url_thumbnail' => $book->url_thumbnail,
							'url_cover' => $book->url_cover,
							'description' => $book->description,
							'price' => $book->price,
							'author' => $book->author,
							'quantity' => $quantity,
							'rating' => $book->rating,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s')
						));
						//update quantity current book
						$book->quantity = $book->quantity - 1;
						$book->save();
						$receiver->hasBook()->save($newBook);

						DB::commit();
						$this->notifySlack($user['name'].' giving book '.$book['title']);
						event(new AcceptGiveBookEvent($user));
					}
					return response()->json(array('status' => 200, 'msg' => 'Tặng sách thành công'));
				}else{
					return response()->json(array('status' => 404, 'msg' => 'Sách đã được tặng hết'));
				}
			}else{
				return response()->json(array('status' => -1, 'msg' => 'Login again'));
			}
		}catch (Exception $e){
			DB::rollback();
			return response()->json($e->getMessage());
		}catch(\Everyman\Neo4j\Exception $e){
			DB::rollback();
			return response()->json($e->getMessage());
		}
	}

	/**
	 * [create description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function create(Request $request)
	{
		//
	}

	/**
	 * [store description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}