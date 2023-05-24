<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\RolePermission\Entities\RolePermission;
use Modules\Setting\Entities\VersionHistory;
use Modules\Setting\Model\Currency;


class FrontendHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenanceMode');
    }

    public function index()
    {
        try {
            if (!\auth()->check()) {
                if (Settings('start_site') == 'loginpage') {
                    return redirect()->route('login');
                }
            }
            $check = FrontPage::select('slug', 'is_static')->where('homepage', 1)->first();
            if ($check && $check->slug != '/') {
                if ($check->is_static == 1) {
                    return redirect()->to($check->slug);
                } else {
                    return redirect()->route('frontPage', [$check->slug]);
                }
            }
            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', '/')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                if (function_exists('SaasDomain')) {
                    $domain = SaasDomain();
                } else {
                    $domain = 'main';
                }
                $blocks = Cache::rememberForever('homepage_block_positions' . $domain, function () {
                    return DB::table('homepage_block_positions')->select(['id', 'block_name', 'order'])->orderBy('order', 'asc')->get();
                });

                return view(theme('pages.index'), compact('blocks'));
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function test()
    {
        $langs = RolePermission::select(
            'permission_id',
            'role_id',
            'status',
            'created_by',
            'updated_by'
        )
            ->get()
            ->toArray();
        echo '<pre>';
        print_r($langs);

        $file = "dump.php";

        if (file_exists($file)) {
            file_put_contents($file, '');
        }

        file_put_contents($file, '<?php return ' . var_export($langs, true) . ';');
        dd("Copyright by @Spondonit");
    }

    public function version()
    {
        return VersionHistory::select('version', 'release_date')->get()->pluck('version', 'release_date')->toArray();
    }


}
