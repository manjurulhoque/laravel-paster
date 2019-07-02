<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\PasteCreateRequest;
use App\Paste;
use App\Syntax;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasteController extends Controller
{
    public function store(PasteCreateRequest $request)
    {
        $ip_address = request()->ip();

        $paste = new Paste();
        $paste->title = $request->title;
        $paste->slug = str_random(10);
        $paste->syntax = (!empty($request->syntax)) ? $request->syntax : "markup";

        switch ($request->expire) {
            case '10M':
                $expire = '10 minutes';
                break;

            case '1H':
                $expire = '1 hour';
                break;

            case '1D':
                $expire = '1 day';
                break;

            case '1W':
                $expire = '1 week';
                break;

            case '2W':
                $expire = '1 week';
                break;

            case '1M':
                $expire = '1 month';
                break;

            case '6M':
                $expire = '6 months';
                break;

            case '1Y':
                $expire = '1 year';
                break;

            case 'SD':
                $expire = 'SD';
                break;

            default:
                $expire = 'N'; // Never destroy
                break;
        }

        if ($expire != 'N') {
            if ($expire == 'SD') {
                $paste->self_destroy = 1;
            } else {
                $paste->expire_time = date('Y-m-d H:i:s', strtotime('+' . $expire));
            }
        }

        $paste->expire = $request->expire;

        $paste->status = $request->status;

        if (auth()->check()) {
            $paste->user_id = auth()->user()->id;
        }
        $paste->ip_address = $ip_address;

        // if encrypt is checked the make the contents encrypted otherwise html entities
        if ($request->encrypt) {
            $paste->encrypt = 1;
            $paste->content = encrypt($request->contents);
        } else {
            $paste->encrypt = 0;
            $paste->content = htmlentities($request->contents);
        }

        $paste->views = 0;

        $paste->save();

        return redirect()->route('paste.show', $paste->slug)->withSuccess('Paste successfully created');
    }

    public function show(Paste $paste)
    {
        $paste->load('user');

        // if status is private
        if ($paste->status == 3) {
            if (auth()->check()) {
                if ($paste->user_id != auth()->user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }

        // If self destroy is given, then expire time will be current date time
        if ($paste->self_destroy == 1 && empty($paste->expire_time)) {
            $paste->expire_time = date("Y-m-d H:i:s");
            $paste->save();
        }

        if (session()->has('already_viewed')) {
            $already_viewed = session('already_viewed');

            if (!in_array($paste->id, $already_viewed)) {
                array_push($already_viewed, $paste->id);
                $paste->views = $paste->views + 1;
                $paste->save();
            }

            session(['already_viewed' => $already_viewed]);
        } else {
            $already_viewed = [$paste->id];
            session(['already_viewed' => $already_viewed]);
            $paste->views = $paste->views + 1;
            $paste->save();
        }

        // check if expire time is given and if time smaller than current time
        if (!empty($paste->expire_time)) {
            if (strtotime($paste->expire_time) < time()) {
                return redirect('/')->withErrors($paste->title . ' ' . __('Paste is expired'));
            }
        }

        $recent_pastes = Paste::where('status', 1)->where(function ($query) {
            $query->where('expire_time', '>', Carbon::now())->orWhereNull('expire_time');
        })->orderBy('created_at', 'desc')->limit(5)->get();

        return view('frontend.pastes.show', compact('paste', 'recent_pastes'));
    }

    public function edit(Paste $paste)
    {
        $recent_pastes = Paste::where('status', 1)->where(function ($query) {
            $query->where('expire_time', '>', Carbon::now())->orWhereNull('expire_time');
        })->orderBy('created_at', 'desc')->limit(5)->get();

        $syntaxes = Syntax::where('active', 1)->get();
        $popular_syntaxes = Syntax::where('popular', 1)->where('active', 1)->get();

        return view('frontend.pastes.edit', compact('paste', 'recent_pastes', 'syntaxes', 'popular_syntaxes'));
    }

    public function update(Paste $paste, Request $request)
    {
        $ip_address = request()->ip();

        $paste->title = $request->title;
        $paste->slug = str_random(10);
        $paste->syntax = (!empty($request->syntax)) ? $request->syntax : "markup";

        switch ($request->expire) {
            case '10M':
                $expire = '10 minutes';
                break;

            case '1H':
                $expire = '1 hour';
                break;

            case '1D':
                $expire = '1 day';
                break;

            case '1W':
                $expire = '1 week';
                break;

            case '2W':
                $expire = '1 week';
                break;

            case '1M':
                $expire = '1 month';
                break;

            case '6M':
                $expire = '6 months';
                break;

            case '1Y':
                $expire = '1 year';
                break;

            case 'SD':
                $expire = 'SD';
                break;

            default:
                $expire = 'N'; // Never destroy
                break;
        }

        if ($expire != 'N') {
            if ($expire == 'SD') {
                $paste->self_destroy = 1;
            } else {
                $paste->expire_time = date('Y-m-d H:i:s', strtotime('+' . $expire));
            }
        }

        $paste->expire = $request->expire;

        $paste->status = $request->status;

        if (auth()->check()) {
            $paste->user_id = auth()->user()->id;
        }
        $paste->ip_address = $ip_address;

        // if encrypt is checked the make the contents encrypted otherwise html entities
        if ($request->encrypt) {
            $paste->encrypt = 1;
            $paste->content = encrypt($request->contents);
        } else {
            $paste->encrypt = 0;
            $paste->content = htmlentities($request->contents);
        }

        $paste->save();

        return redirect()->route('paste.show', $paste->slug)->with('success', 'Paste successfully updated');
    }

    public function destroy(Paste $paste)
    {
        $paste->delete();
        return redirect()->route('home')->with('success', 'Paste successfully deleted');
    }

    public function raw(Paste $paste)
    {
        if ($paste->status == 3) {
            if (auth()->check()) {
                if ($paste->user_id != auth()->user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }

        }

        if (!empty($paste->expire_time)) {
            if (strtotime($paste->expire_time) < time()) {
                return redirect('/')->withErrors($paste->title . ' ' . 'Paste is expired');
            }
        }

        if (session()->has('already_viewed')) {
            $already_viewed = session('already_viewed');

            if (!in_array($paste->id, $already_viewed)) {
                array_push($already_viewed, $paste->id);
                $paste->views = $paste->views + 1;
                $paste->save();
            }

            session(['already_viewed' => $already_viewed]);
        } else {
            $already_viewed = [$paste->id];
            session(['already_viewed' => $already_viewed]);
            $paste->views = $paste->views + 1;
            $paste->save();
        }

        return response($paste->content, 200)
            ->header('Content-Type', 'text/plain');
    }

    public function download(Paste $paste)
    {
        if ($paste->status == 3) {
            if (auth()->check()) {
                if ($paste->user_id != auth()->id()) {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }

        if (!empty($paste->expire_time)) {
            if (strtotime($paste->expire_time) < time()) {
                return redirect('/')->withErrors($paste->title . ' ' . 'Paste is expired');
            }
        }

        $extension = (isset($paste->language)) ? $paste->language->file_extension : 'txt';
        $response = response($paste->content, 200, [
            'Content-Disposition' => 'attachment; filename="' . $paste->title . '.' . $extension . '"',
        ]);

        return $response;
    }

    public function clone(Paste $paste)
    {
        if ($paste->status == 3) {
            if (auth()->check()) {
                if ($paste->user_id != auth()->id()) {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }

        if (!empty($paste->expire_time)) {
            if (strtotime($paste->expire_time) < time()) {
                return redirect('/')->withErrors($paste->title . ' ' . 'Paste is expired');
            }
        }

        $recent_pastes = Paste::where('status', 1)->where(function ($query) {
            $query->where('expire_time', '>', Carbon::now())->orWhereNull('expire_time');
        })->orderBy('created_at', 'desc')->limit(5)->get();

        if (auth()->check()) {
            $my_recent_pastes = Paste::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->limit(6)->get();
        } else {
            $my_recent_pastes = [];
        }

        $syntaxes = Syntax::where('active', 1)->get();
        $popular_syntaxes = Syntax::where('popular', 1)->where('active', 1)->get();

        return view('frontend.pages.clone', compact('paste', 'recent_pastes', 'my_recent_pastes', 'syntaxes', 'popular_syntaxes'));
    }

    public function embed($slug)
    {
        $paste = Paste::where('slug', $slug)->firstOrfail();
        if ($paste->status == 3) {
            if (auth()->check()) {
                if ($paste->user_id != auth()->user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }

        if (!empty($paste->expire_time)) {
            if (strtotime($paste->expire_time) < time()) {
                return $paste->title . ' ' . 'Paste is expired';
            }
        }


        if (session()->has('already_viewed')) {
            $already_viewed = session('already_viewed');

            if (!in_array($paste->id, $already_viewed)) {
                array_push($already_viewed, $paste->id);
                $paste->views = $paste->views + 1;
                $paste->save();
            }

            session(['already_viewed' => $already_viewed]);
        } else {
            $already_viewed = [$paste->id];
            session(['already_viewed' => $already_viewed]);
            $paste->views = $paste->views + 1;
            $paste->save();
        }

        return view('frontend.pages.embed', compact('paste'));
    }

    public function report(Paste $paste, Request $request)
    {
        $this->validate($request, [
            'reason' => 'required|min:8'
        ]);

        $paste->reports()->create([
            'user_id' => auth()->id(),
            'reason' => $request->reason
        ]);

        return back()->with('success', 'Paste is reported to admin successfully');
    }

    public function print(Paste $paste)
    {
        if ($paste->status == 3) {
            if (auth()->check()) {
                if ($paste->user_id != auth()->user()->id) {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }

        if (!empty($paste->expire_time)) {
            if (strtotime($paste->expire_time) < time()) {
                return $paste->title . ' ' . 'Paste is expired';
            }
        }

        if (session()->has('already_viewed')) {
            $already_viewed = session('already_viewed');

            if (!in_array($paste->id, $already_viewed)) {
                array_push($already_viewed, $paste->id);
                $paste->views = $paste->views + 1;
                $paste->save();
            }

            session(['already_viewed' => $already_viewed]);
        } else {
            $already_viewed = [$paste->id];
            session(['already_viewed' => $already_viewed]);
            $paste->views = $paste->views + 1;
            $paste->save();
        }

        return view('frontend.pages.print', compact('paste'));
    }
}
