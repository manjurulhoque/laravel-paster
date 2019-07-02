<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Paste;
use App\Syntax;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $syntaxes = Syntax::where('active', 1)->get();
        $popular_syntaxes = Syntax::where('popular', 1)->where('active', 1)->get();
        $recent_pastes = Paste::where('status', 1)->where(function ($query) {
            $query->where('expire_time', '>', Carbon::now())->orWhereNull('expire_time');
        })->orderBy('created_at', 'desc')->limit(5)->get();

        if (auth()->check()) {
            $my_recent_pastes = Paste::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->limit(6)->get();
        } else {
            $my_recent_pastes = [];
        }

        return view('frontend.pages.home', compact('syntaxes', 'popular_syntaxes', 'recent_pastes', 'my_recent_pastes'));
    }

    public function trending()
    {
        $trending_today = Paste::whereDate('created_at', date('Y-m-d'))->orderby('views', 'DESC')->limit(5)->get();

        $trending_week = Paste::whereBetween('created_at', [
            Carbon::parse('last saturday')->startOfDay(),
            Carbon::parse('next friday')->endOfDay(),
        ])->orderby('views', 'DESC')->limit(5)->get();

        $trending_month = Paste::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])->orderby('views', 'DESC')->limit(5)->get();

        $recent_pastes = Paste::where('status', 1)->where(function ($query) {
            $query->where('expire_time', '>', Carbon::now())->orWhereNull('expire_time');
        })->orderBy('created_at', 'desc')->limit(5)->get();

        return view('frontend.pages.trending', compact('trending_today', 'trending_week', 'trending_month', 'recent_pastes'));
    }

    public function archives()
    {
        $syntaxes = Syntax::where('active', 1)->orderby('name')->get();
        $recent_pastes = Paste::where('status', 1)->where(function ($query) {
            $query->where('expire_time', '>', Carbon::now())->orWhereNull('expire_time');
        })->orderBy('created_at', 'desc')->limit(config('settings.recent_pastes_limit'))->get();

        if (auth()->check()) {
            $my_recent_pastes = Paste::where('user_id', auth()->id())->orderBy('created_at', 'desc')->limit(6)->get();
        } else {
            $my_recent_pastes = [];
        }

        return view('frontend.pages.archives', compact('syntaxes', 'recent_pastes', 'my_recent_pastes'));
    }

    public function single_archive($slug)
    {
        $syntax = Syntax::where('slug', $slug)->first();

        $pastes = Paste::where('syntax', $slug)->where(function ($query) {
            $query->where('expire_time', '>', Carbon::now())->orWhereNull('expire_time');
        })->where('status', 1)->orderBy('created_at', 'DESC')->paginate(10);

        $recent_pastes = Paste::where('status', 1)->where(function ($query) {
            $query->where('expire_time', '>', Carbon::now())->orWhereNull('expire_time');
        })->orderBy('created_at', 'desc')->limit(6)->get();

        if (auth()->check()) {
            $my_recent_pastes = Paste::where('user_id', auth()->id())->orderBy('created_at', 'desc')->limit(6)->get();
        } else {
            $my_recent_pastes = [];
        }

        return view('frontend.pages.single_archive', compact('pastes', 'syntax', 'recent_pastes', 'my_recent_pastes'));
    }
}
