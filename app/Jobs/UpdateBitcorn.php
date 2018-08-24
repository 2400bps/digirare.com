<?php

namespace App\Jobs;

use Curl\Curl;
use App\Curator;
use App\Traits\ImportsCards;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateBitcorn implements ShouldQueue
{
    use Dispatchable, ImportsCards, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Curl
     *
     * @var \Curl\Curl
     */
    protected $curl;

    /**
     * Curator
     *
     * @var \App\Curator
     */
    protected $curator;

    /**
     * Override Existing Images
     *
     * @var boolean
     */
    protected $override;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Curator $curator, $override=false)
    {
        $this->curator = $curator;
        $this->override = $override;
        $this->curl = new Curl();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Bitcorn Crops API
        $cards = $this->getAPI();

        // Update or Create
        foreach($cards as $data)
        {
            // The Asset
            $xcp_core_asset_name = $this->getAssetName($data['name']);

            // Image URL
            $image_url = $this->getImageUrl($data['card'], $this->override);

            // Creation
            $card = $this->firstOrCreateCard($xcp_core_asset_name, $data['name']);

            // Relation
            $card->curators()->sync([$this->curator->id => ['image_url' => $image_url]]);
        }
    }

    /**
     * Get API
     * 
     * @return array
     */
    private function getAPI()
    {
        // Get API
        $this->curl->get('https://bitcorns.com/api/cards');

        // API Error
        if ($this->curl->error) return [];

        // Response
        return json_decode($this->curl->response, true);
    }
}