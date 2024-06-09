<?php

namespace App\Http\Controllers;

class GeneralController extends Controller
{
    public function home()
    {
        return view('frontend.home');
    }

    public function createtour()
    {
        return view('frontend.createtour');
    }

    public function detailtour()
    {
        return view('frontend.detailtour');
    }

    public function detailtourvalo()
    {
        return view('frontend.detailtourvalo');
    }

    public function detaildonation()
    {
        return view('frontend.detaildonation');
    }

    public function mainblog()
    {
        return view('frontend.mainblog');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function blog()
    {
        return view('frontend.blog');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function tournament()
    {
        return view('frontend.tournament');
    }

}
