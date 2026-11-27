<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait ApiConfigurationTrait
{
    // ✅ Gunakan private untuk menghindari konflik
    private $apiDomain = "https://jkei.jvckenwood.com/";
    private $apiUrl = "api/custom/";
    private $apiVersion = "versioning..";

    /**
     * Inisialisasi konfigurasi API berdasarkan server name
     * 
     * @return void
     */
    protected function initializeApiConfiguration()
    {
        try {
            $this->setDomainBasedOnServer();
            Log::info('ApiConfigurationTrait: Konfigurasi berhasil diinisialisasi', [
                'domain' => $this->apiDomain,
                'version' => $this->apiVersion
            ]);
        } catch (\Exception $e) {
            Log::error('ApiConfigurationTrait: Error saat inisialisasi', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Set domain berdasarkan server name
     * 
     * @return void
     */
    private function setDomainBasedOnServer()
    {
        $serverName = $_SERVER['SERVER_NAME'] ?? 'localhost';
        $base = rtrim((string) config('services.inventory.url', 'https://jkei.jvckenwood.com/api/custom'), '/');
        $slash = strpos($base, '/', 8);

        if ($slash === false) {
            $this->apiDomain = $base . '/';
            $this->apiUrl = '';
        } else {
            $this->apiDomain = substr($base, 0, $slash + 1);
            $this->apiUrl = substr($base, $slash + 1) . '/';
        }

        $this->domain = $this->apiDomain;
        $this->url = $this->apiUrl;

        Log::info('API Domain initialized', [
            'server_name' => $serverName,
            'domain' => $this->apiDomain,
            'url' => $this->apiUrl,
        ]);
    }

    protected function apiHttp()
    {
        return Http::withHeaders([
            'X-Api-Key' => (string) config('services.inventory.key'),
        ]);
    }

    /**
     * Get version dengan error handling yang robust
     * 
     * @return string
     */
    public function getVersionSafely()
    {
        try {
            $version = Cache::store('file')->remember('gitinventory.api_version', 600, function () {
                $url = $this->apiDomain . $this->apiUrl . "json_version_sync.php";
                $response = $this->apiHttp()->connectTimeout(3)->timeout(8)->get($url);

                if ($response->successful()) {
                    return $response->json('version') ?? '3.0.0';
                }

                Log::warning('Version fetch failed', ['status' => $response->status()]);
                return $this->apiVersion;
            });

            $this->apiVersion = $version;
            return $version;
        } catch (\Exception $e) {
            Log::error('Exception occurred while fetching version', [
                'message' => $e->getMessage()
            ]);
            return $this->apiVersion;
        }
    }

    /**
     * Get full API URL
     * 
     * @param string $endpoint
     * @return string
     */
    public function getApiUrl($endpoint = '')
    {
        return $this->domain . $this->url . $endpoint;
    }

    /**
     * Make HTTP GET request ke API dengan error handling
     * 
     * @param string $endpoint
     * @param array $params
     * @return array|null
     */
    protected function makeApiRequest($endpoint, $params = [])
    {
        try {
            $url = $this->getApiUrl($endpoint);
            
            Log::info('Making API request', [
                'url' => $url,
                'params' => $params
            ]);
            
            // ✅ Timeout 30 detik untuk semua request
            $response = $this->apiHttp()->timeout(30)->get($url, $params);
            
            if ($response->successful()) {
                Log::info('API request successful', [
                    'url' => $url,
                    'status' => $response->status()
                ]);
                return $response->json();
            }
            
            Log::warning('API request failed', [
                'url' => $url,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return null;
            
        } catch (\Exception $e) {
            Log::error('API request exception', [
                'url' => $url ?? 'unknown',
                'message' => $e->getMessage()
            ]);
            
            return null;
        }
    }

    /**
     * Make login request ke API dengan error handling
     * 
     * @param string $userid
     * @param string $userpass
     * @param string $ipaddress
     * @return \Illuminate\Http\Client\Response|null
     */
    protected function makeLoginRequest($userid, $userpass, $ipaddress = null)
    {
        try {
            $ipaddress = $ipaddress ?? getenv("REMOTE_ADDR");
            $url = $this->getApiUrl('json_login_sync.php');
            
            $params = [
                'valuserid' => $userid,
                'valuserpass' => $userpass,
                'valipaddress' => $ipaddress,
            ];
            
            Log::info('Making login API request', [
                'url' => $url,
                'userid' => $userid,
                'ip' => $ipaddress
            ]);
            
            $response = $this->apiHttp()->asForm()->timeout(30)->post($url, $params);
            
            Log::info('Login API response received', [
                'status' => $response->status(),
                'successful' => $response->successful()
            ]);
            
            return $response;
            
        } catch (\Exception $e) {
            Log::error('Login API request exception', [
                'url' => $url ?? 'unknown',
                'message' => $e->getMessage(),
                'userid' => $userid
            ]);
            
            return null;
        }
    }
    
    /**
     * Check API health sebelum melakukan request
     */
    public function isApiHealthy(): bool
    {
        try {
            $response = $this->apiHttp()->get($this->domain . $this->url . 'health-check.php');
            return $response->successful();
        } catch (Exception $e) {
            return false;
        }
    }
}
