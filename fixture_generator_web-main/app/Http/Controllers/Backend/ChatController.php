<?php
namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Chat;
use App\Models\QrCode;
use SimpleSoftwareIO\QrCode\Generator;
use App\Models\Message;
use App\Models\SendMessage;
use Illuminate\Support\Facades\Http;

class ChatController extends BaseController
{
    use BasePattern;

    public function __construct()
    {
        $this->page = 'chat';
        $this->title = __('models.chat.model_name');
        $this->model = new Chat();
        $this->listQuery = $this->model->query();

        parent::__construct();
    }

    public function list(Request $request)
    {
        $qr = QrCode::query()->where("is_active", true)->first();

        if($qr){
            return redirect()->route("chat.qr");
        }


        $compact = [
            'chat' => null
        ];

        return view('backend.chat.message-box', $compact);
    }

    public function send(Request $request, Chat $chat){
        $message = SendMessage::query()->create([
            "chat_id" => $chat->id,
            "body" => $request->body,
            "status" => 0
        ]);

        if($request->hasFile("file")){
            fileManager($message, $request->files);
        }

        $http = Http::get("http://127.0.0.1:5000/api/messages/pool");
        if($http->json()["status"] != true){
            return redirect()->back()->with("error", "Whatsapp is not running");
        }

        return redirect()->back();
    }

    public function box(Request $request, Chat $chat){

        $qr = QrCode::query()->where("is_active", true)->first();

        if($qr){
            return redirect()->route("chat.qr");
        }

        $compact = [
            'chat' => $chat
        ];

        return view("backend.chat.message-box", $compact);

    }


    public function qr(Request $request){
        $qr = QrCode::query()->where("is_active", true)->first();
        if($request->get("ajax", false)){
            return response()->json([
                "status" => $qr == null ? false : true,
                "data" => route("chat.qr_view", ["qr" => $qr->id]),
            ]);
        }

        if($qr == null){
            return redirect()->route("chat.list")->with("error", "QR Zaten Bağlanmış...");
        }

        return view("backend.chat.qr");
    }

    public function qr_view(Request $request, QrCode $qr){
        $qrCode = new Generator();
        $qrCode->encoding('UTF-8');
        $qrCode->size(480);
        $qrCode->eye('circle');
        $qrCode->style('round');
        $qrCode->color(37,211,102);

        return response($qrCode->generate($qr->code))->header('Content-type','image/svg+xml');
    }

}
