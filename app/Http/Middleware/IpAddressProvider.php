<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;

class IpAddressProvider
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check IP Addresses
        $allowedIps = config('allowedIps.ips');
        $ipaddress = $request->ip();

        if (!$this->isAllowedIp($ipaddress, $allowedIps) && $this->isFromPakistan($ipaddress)) {
            abort(403);
        }
        return $next($request);
    }

    private function isAllowedIp($ip, $allowedIps)
    {
        return in_array($ip, $allowedIps);
    }

    private function isFromPakistan($ip)
    {
        $response = Http::get("https://ipinfo.io/".$ip."?token=d568801900a966");
        if ($response->successful()) {
            $data = $response->json();
            return isset($data['country']) && $data['country'] === 'PK';
        }

        return false; // Consider as not from Pakistan if the request fails
    }
}