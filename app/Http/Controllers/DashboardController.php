<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Asset;
use App\Models\Transaction;
use App\Models\Maintenance;
use App\Models\Ticket;
use App\Models\Customer;
use App\Models\MonitoringReading;
use App\Models\MappingStudyReading;
use Illuminate\Support\Facades\DB;

use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\Auth;

class DashboardController extends DefaultController
{
    protected $title;
    protected $generalUri;

    public function __construct()
    {
        $this->title = 'Dashboard';
        $this->generalUri = 'dashboard';
    }


    public function index()
    {
        $user = Auth::user();
        $data['title'] = $this->title;

        // Total Statistics
        $data['total_employees'] = Employee::count();
        $data['total_assets'] = Asset::count();
        $data['total_transactions'] = Transaction::count();
        $data['total_maintenances'] = Maintenance::count();
        $data['total_tickets'] = Ticket::count();
        if (in_array($user->role->name, ['admin', 'developer'])) {
            $data['total_customers'] = Customer::count();
            // Admin & Developer: semua customer
        } elseif ($user->role->name === 'apj') {
            // APJ: customer berdasarkan user_id
            $data['total_customers'] = Customer::where('user_id', $user->id)->count();
        }

        // Asset by Status
        $data['assets_active'] = Asset::where('is_status', 'active')->count();
        $data['assets_backup'] = Asset::where('is_status', 'backup')->count();
        $data['assets_standby'] = Asset::where('is_status', 'standby')->count();
        $data['assets_broken'] = Asset::where('is_status', 'broken')->count();

        // Asset by Category
        $data['asset_by_category'] = Asset::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderBy('total', 'DESC')
            ->get();

        // Recent Transactions
        $data['recent_transactions'] = Transaction::join('employees', 'employees.nik', '=', 'transactions.nik')
            ->join('assets', 'assets.id', '=', 'transactions.asset_id')
            ->select('transactions.*', 'employees.nama', 'assets.code', 'assets.category', 'assets.merk', 'assets.model')
            ->orderBy('transactions.created_at', 'DESC')
            ->limit(5)
            ->get();

        // Recent Maintenances
        $data['recent_maintenances'] = Maintenance::join('assets', 'assets.id', '=', 'maintenances.asset_id')
            ->select('maintenances.*', 'assets.code', 'assets.category', 'assets.merk', 'assets.model')
            ->orderBy('maintenances.date', 'DESC')
            ->limit(5)
            ->get();

        // Active Transactions
        $data['active_transactions'] = Transaction::where('is_active', 'active')->count();
        $data['backup_transactions'] = Transaction::where('is_active', 'backup')->count();
        $data['standby_transactions'] = Transaction::where('is_active', 'standby')->count();

        // Maintenance This Month
        $data['maintenance_this_month'] = Maintenance::whereMonth('date', date('m'))
            ->whereYear('date', date('Y'))
            ->count();

        // Ticket Statistics
        $data['tickets_open'] = Ticket::where('status', 'open')->count();
        $data['tickets_process'] = Ticket::where('status', 'process')->count();
        $data['tickets_closed'] = Ticket::where('status', 'closed')->count();

        // Recent Tickets
        $data['recent_tickets'] = Ticket::join('employees', 'employees.id', '=', 'tickets.employee_id')
            ->select('tickets.*', 'employees.nama')
            ->orderBy('tickets.created_at', 'DESC')
            ->limit(5)
            ->get();

        // Latest Temperature Reading (from monitoring or mapping)
        $latestMonitoring = MonitoringReading::orderBy('recorded_at', 'DESC')->first();
        $latestMapping = MappingStudyReading::orderBy('recorded_at', 'DESC')->first();

        // Determine which is the most recent
        if ($latestMonitoring && $latestMapping) {
            if ($latestMonitoring->recorded_at >= $latestMapping->recorded_at) {
                $data['latest_temp_value'] = $latestMonitoring->value;
                $data['latest_temp_time'] = $latestMonitoring->recorded_at;
                $data['latest_temp_source'] = 'monitoring';
            } else {
                $data['latest_temp_value'] = $latestMapping->value;
                $data['latest_temp_time'] = $latestMapping->recorded_at;
                $data['latest_temp_source'] = 'mapping';
            }
        } elseif ($latestMonitoring) {
            $data['latest_temp_value'] = $latestMonitoring->value;
            $data['latest_temp_time'] = $latestMonitoring->recorded_at;
            $data['latest_temp_source'] = 'monitoring';
        } elseif ($latestMapping) {
            $data['latest_temp_value'] = $latestMapping->value;
            $data['latest_temp_time'] = $latestMapping->recorded_at;
            $data['latest_temp_source'] = 'mapping';
        } else {
            $data['latest_temp_value'] = null;
            $data['latest_temp_time'] = null;
            $data['latest_temp_source'] = null;
        }

        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.dashboard_ajax' : 'backend.idev.dashboard';

        return view($layout, $data);
    }
}
