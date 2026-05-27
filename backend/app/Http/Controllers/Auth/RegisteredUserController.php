<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * Creates the user, their restaurant, and sensible defaults
     * (theme + QR style) all within a single transaction.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'        => ['required', 'confirmed', Rules\Password::defaults()],
            'restaurant_name' => ['required', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($request, &$user) {
            // 1. Create user
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 2. Create restaurant with a unique slug
            $restaurant = $user->restaurant()->create([
                'name'      => $request->restaurant_name,
                'slug'      => Restaurant::generateUniqueSlug($request->restaurant_name),
                'menu_type' => 'dynamic',
            ]);

            // 3. Default theme — warm orange/dark palette
            $restaurant->theme()->create([
                'primary_color'    => '#FF6B35',
                'secondary_color'  => '#2E294E',
                'background_color' => '#FFFFFF',
                'text_color'       => '#1A1A2E',
                'font_family'      => 'Outfit',
                'card_style'       => 'rounded',
                'dark_mode'        => false,
                'layout_style'     => 'grid',
            ]);

            // 4. Default QR style
            $restaurant->qrStyle()->create([
                'dot_style'           => 'rounded',
                'corner_square_style' => 'extra-rounded',
                'corner_dot_style'    => 'dot',
                'dot_color'           => '#000000',
                'background_color'    => '#FFFFFF',
                'gradient_enabled'    => false,
            ]);
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard.index'));
    }
}
