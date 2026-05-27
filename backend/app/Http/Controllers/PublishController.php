<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Services\GitHubSyncService;
use App\Services\MenuJsonGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Handles the publishing of draft menus to the static JSON structure on GitHub.
 */
class PublishController extends Controller
{
    public function __construct(
        private readonly MenuJsonGenerator $jsonGenerator,
        private readonly GitHubSyncService $gitHubSync
    ) {}

    /**
     * Publish unpublished changes for the authenticated user's restaurant.
     */
    public function publish(Request $request): RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('restaurant');

        if (! $restaurant->has_unpublished_changes) {
            return back()->with('info', 'No unpublished changes to publish.');
        }

        return $this->executePublish($restaurant);
    }

    /**
     * Retry a previously failed publish attempt.
     */
    public function retry(Request $request): RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('restaurant');

        if ($restaurant->last_sync_status !== 'failed') {
            return back()->with('info', 'No failed publish to retry.');
        }

        return $this->executePublish($restaurant);
    }

    /**
     * Execute the generation and sync flow.
     */
    private function executePublish(Restaurant $restaurant): RedirectResponse
    {
        try {
            // 1. Generate the JSON payload (array)
            $menuData = $this->jsonGenerator->generate($restaurant);
            
            // Encode to JSON string for Github sync
            $jsonString = json_encode($menuData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            if ($jsonString === false) {
                throw new \RuntimeException('Failed to encode menu data to JSON.');
            }

            // 2. Sync to GitHub
            $this->gitHubSync->syncMenuJson($restaurant, $jsonString);

            // 3. Update database state on success
            $restaurant->update([
                'has_unpublished_changes' => false,
                'last_published_at'       => now(),
                'last_sync_status'        => 'success',
                'sync_error_message'      => null,
            ]);

            return back()->with('success', 'Menu published successfully! The live menu will update in a few moments.');

        } catch (\Exception $e) {
            Log::error('Publish failed', [
                'restaurant_id' => $restaurant->id,
                'error'         => $e->getMessage(),
                'trace'         => $e->getTraceAsString(),
            ]);

            // Update database state on failure
            $restaurant->update([
                'last_sync_status'   => 'failed',
                'sync_error_message' => substr($e->getMessage(), 0, 1000), // Prevent too long error messages
            ]);

            return back()->with('error', 'Publish failed: ' . $e->getMessage());
        }
    }
}
