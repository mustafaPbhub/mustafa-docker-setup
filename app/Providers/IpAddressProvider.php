<?php

namespace App\Providers;

use App\Models\IpAddress;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class IpAddressProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $ipaddressdata = $this->settings();
        $all_ips = [];
        if (Schema::hasTable('ip_addresses')) {
            $all_ips = IpAddress::where('status', 1)->pluck('ip')->toArray();
        }
        if (!empty($ipaddressdata)) {

            config([
                'allowedIps.ips' => $all_ips,
            ]);
        }
    }
    public function settings()
    {
        if (Schema::hasTable('ip_addresses')) {
            $ipadd = IpAddress::orderBy('id', 'desc')->first();
            if (!empty($ipadd)) {
                return $ipadd;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}