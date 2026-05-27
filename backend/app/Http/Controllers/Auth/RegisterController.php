<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Register a new restaurant owner.
     *
     * Creates:
     *  - User account
     *  - Restaurant (with auto-generated unique slug)
     *  - Default Theme (sensible design defaults)
     *  - Default QrStyle (ready for customization)
     *
     * Returns a Sanctum Bearer token so the frontend can authenticate immediately.
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $result = DB::transaction(function () use ($request) {
            // 1. Create user
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password, // hashed via model cast
            ]);

            // 2. Create restaurant with a unique URL-safe slug
            $restaurant = $user->restaurant()->create([
                'name'      => $request->restaurant_name,
                'slug'      => Restaurant::generateUniqueSlug($request->restaurant_name),
                'menu_type' => 'dynamic',
            ]);

            // 3. Create default theme — warm orange + deep purple palette
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

            // 4. Create default QR style
            $restaurant->qrStyle()->create([
                'dot_style'           => 'rounded',
                'corner_square_style' => 'extra-rounded',
                'corner_dot_style'    => 'dot',
                'dot_color'           => '#000000',
                'background_color'    => '#FFFFFF',
                'gradient_enabled'    => false,
            ]);

            // 5. Issue Sanctum token — previous tokens revoked on login, not here
            $token = $user->createToken('auth_token')->plainTextToken;

            return compact('user', 'restaurant', 'token');
        });

        return response()->json([
            'message'    => 'Account created successfully.',
            'user'       => $result['user'],
            'restaurant' => $result['restaurant']->load('theme', 'qrStyle'),
            'token'      => $result['token'],
        ], 201);
    }
}
