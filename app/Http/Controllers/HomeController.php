<?php

namespace App\Http\Controllers;

use App\Car;
use App\Mail\NewCars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('auth.login');
    }

    public function test() {
        $collection = collect();
        $car = new Car();
        $car->title = 'асйдхжбасджбак йксхажбйахс ж';
        $car->desc = 'йасхджб акйсхджбйасх джбйахс джбйх асждбх йгасдж хгасж дха схйгдж айхсдж';
        $car->image = 'www.mobile.bg/images/picturess/photo_big1.gif';
        $car->price = '14 000 лв.';

        $car2 = clone $car;
        $car2->image = 'https://sc02-ha-b.mobile.bg/photos1/1/med/11544389982423309_1.pic';
        $car2->desc = 'асйхджб акйсхдбжайсгдбжйгахсдж ад йжгасдхгс ждхгж гс жгйс хжс';

        $collection->push($car);
        $collection->push($car2);

        $mailObj = new NewCars($collection);
        Mail::to('bloodlisterer@gmail.com')->send($mailObj);

        return response("Done");
    }
}
