@extends("easyadmin::backend.parent")
@section("content")
@push('mtitle')
{{$title}}
@endpush
<div class="pc-container">
  <div class="pc-content">

    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="page-header-title">
              <h4 class="m-b-10">Hi, <b>{{ Auth::user()->name }}</b>!</h4>
              @if(config('idev.enable_role',true))
              <p class="m-b-0">Welcome to your dashboard - You are logged in as <i class="text-primary">{{ Auth::user()->role->name }}</i></p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

    @if(Auth::user()->role->name == 'developer')
    <!-- Statistics Cards -->
    <div class="row">
      <!-- Total Employees -->
      <div class="col-md-6 col-xl-3">
        <div class="card bg-primary dashnum-card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <span class="text-white text-uppercase">Total Employees</span>
                <h2 class="f-w-300 text-white m-t-10">{{ number_format($total_employees) }}</h2>
              </div>
              <div class="col-auto">
                <i class="ti ti-users text-white f-50 opacity-25"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Assets -->
      <div class="col-md-6 col-xl-3">
        <div class="card bg-success dashnum-card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <span class="text-white text-uppercase">Total Assets</span>
                <h2 class="f-w-300 text-white m-t-10">{{ number_format($total_assets) }}</h2>
              </div>
              <div class="col-auto">
                <i class="ti ti-device-laptop text-white f-50 opacity-25"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Transactions -->
      <div class="col-md-6 col-xl-3">
        <div class="card bg-warning dashnum-card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <span class="text-white text-uppercase">Total Transactions</span>
                <h2 class="f-w-300 text-white m-t-10">{{ number_format($total_transactions) }}</h2>
              </div>
              <div class="col-auto">
                <i class="ti ti-exchange text-white f-50 opacity-25"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Tickets -->
      <div class="col-md-6 col-xl-3">
        <div class="card bg-info dashnum-card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <span class="text-white text-uppercase">Total Tickets</span>
                <h2 class="f-w-300 text-white m-t-10">{{ number_format($total_tickets) }}</h2>
              </div>
              <div class="col-auto">
                <i class="ti ti-ticket text-white f-50 opacity-25"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      
    </div>

    <!-- Second Row Statistics -->
    <div class="row">
      <!-- Total Maintenances -->
      <div class="col-md-6 col-xl-3">
        <div class="card bg-danger dashnum-card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <span class="text-white text-uppercase">Total Maintenances</span>
                <h2 class="f-w-300 text-white m-t-10">{{ number_format($total_maintenances) }}</h2>
              </div>
              <div class="col-auto">
                <i class="ti ti-settings-automation text-white f-50 opacity-25"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tickets Open -->
      <div class="col-md-6 col-xl-3">
        <div class="card bg-light-primary dashnum-card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <span class="text-uppercase">Tickets Open</span>
                <h2 class="f-w-300 m-t-10">{{ number_format($tickets_open) }}</h2>
              </div>
              <div class="col-auto">
                <i class="ti ti-circle-dotted text-primary f-50 opacity-25"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tickets In Process -->
      <div class="col-md-6 col-xl-3">
        <div class="card bg-light-warning dashnum-card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <span class="text-uppercase">Tickets Process</span>
                <h2 class="f-w-300 m-t-10">{{ number_format($tickets_process) }}</h2>
              </div>
              <div class="col-auto">
                <i class="ti ti-refresh text-warning f-50 opacity-25"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tickets Closed -->
      <div class="col-md-6 col-xl-3">
        <div class="card bg-light-success dashnum-card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <span class="text-uppercase">Tickets Closed</span>
                <h2 class="f-w-300 m-t-10">{{ number_format($tickets_closed) }}</h2>
              </div>
              <div class="col-auto">
                <i class="ti ti-circle-check text-success f-50 opacity-25"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Customers -->
      <div class="col-md-6 col-xl-3">
        <div class="card bg-secondary dashnum-card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <span class="text-white text-uppercase">Total Customers</span>
                <h2 class="f-w-300 text-white m-t-10">{{ number_format($total_customers) }}</h2>
              </div>
              <div class="col-auto">
                <i class="ti ti-building-store text-white f-50 opacity-25"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-xl-3">
          <a href="{{ route('scanner-temperature') }}">
            <div class="card dashnum-card">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <span class="text-uppercase">Pengecekan Suhu</span>
                    @if($latest_temp_value !== null)
                    <h2 class="f-w-300 m-t-10">{{ number_format($latest_temp_value, 1) }} °C</h2>
                    {{-- <small class="text-muted">{{ $latest_temp_time->format('d M Y, H:i') }}</small> --}}
                    {{-- <br> --}}
                    {{-- <small class="badge badge-light-primary">{{ ucfirst($latest_temp_source) }}</small> --}}
                    @else
                    <h2 class="f-w-300 m-t-10">No Data</h2>
                    {{-- <small class="text-muted">Belum ada data</small> --}}
                    @endif
                  </div>
                  <div class="col-auto">
                    <i class="ti ti-qrcode f-50 opacity-25"></i>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      
    </div>
    @elseif(in_array(Auth::user()->role->name, ['apj']))
    <!-- Statistics Cards -->
    <div class="row">
      <!-- Total Customers -->
      <div class="col-md-6 col-xl-3">
        <div class="card bg-secondary dashnum-card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <span class="text-white text-uppercase">Total Customers</span>
                <h2 class="f-w-300 text-white m-t-10">{{ number_format($total_customers) }}</h2>
              </div>
              <div class="col-auto">
                <i class="ti ti-building-store text-white f-50 opacity-25"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @elseif(in_array(Auth::user()->role->name, ['admin']))
    <!-- Statistics Cards -->
    <div class="row">
      <!-- Total Customers -->
      <div class="col-md-6 col-xl-3">
        <div class="card bg-secondary dashnum-card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <span class="text-white text-uppercase">Total Customers</span>
                <h2 class="f-w-300 text-white m-t-10">{{ number_format($total_customers) }}</h2>
              </div>
              <div class="col-auto">
                <i class="ti ti-building-store text-white f-50 opacity-25"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-xl-3">
          <a href="{{ route('scanner-temperature') }}">
            <div class="card dashnum-card">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <span class="text-uppercase">Pengecekan Suhu</span>
                    @if($latest_temp_value !== null)
                    <h2 class="f-w-300 m-t-10">{{ number_format($latest_temp_value, 1) }} °C</h2>
                    {{-- <small class="text-muted">{{ $latest_temp_time->format('d M Y, H:i') }}</small> --}}
                    {{-- <br> --}}
                    {{-- <small class="badge badge-light-primary">{{ ucfirst($latest_temp_source) }}</small> --}}
                    @else
                    <h2 class="f-w-300 m-t-10">No Data</h2>
                    {{-- <small class="text-muted">Belum ada data</small> --}}
                    @endif
                  </div>
                  <div class="col-auto">
                    <i class="ti ti-qrcode f-50 opacity-25"></i>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
    </div>

    @endif

    @if(Auth::user()->role->name == 'developer')
    <!-- Asset Status & Category -->
    <div class="row">
      <!-- Asset by Status -->
      <div class="col-md-6 col-xl-4">
        <div class="card">
          <div class="card-header">
            <h5>Assets by Status</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted">Active</span>
                    <span class="badge bg-success">{{ $assets_active }}</span>
                  </div>
                  <div class="progress mt-2" style="height: 6px;">
                    <div class="progress-bar bg-success" style="width: {{ $total_assets > 0 ? ($assets_active/$total_assets)*100 : 0 }}%"></div>
                  </div>
                </div>
                <div class="mb-3">
                  <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted">Standby</span>
                    <span class="badge bg-info">{{ $assets_standby }}</span>
                  </div>
                  <div class="progress mt-2" style="height: 6px;">
                    <div class="progress-bar bg-info" style="width: {{ $total_assets > 0 ? ($assets_standby/$total_assets)*100 : 0 }}%"></div>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted">Backup</span>
                    <span class="badge bg-warning">{{ $assets_backup }}</span>
                  </div>
                  <div class="progress mt-2" style="height: 6px;">
                    <div class="progress-bar bg-warning" style="width: {{ $total_assets > 0 ? ($assets_backup/$total_assets)*100 : 0 }}%"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Asset by Category -->
      <div class="col-md-6 col-xl-4">
        <div class="card">
          <div class="card-header">
            <h5>Assets by Category</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-sm table-borderless">
                <tbody>
                  @forelse($asset_by_category as $category)
                  <tr>
                    <td>
                      <h6 class="mb-0">{{ ucfirst($category->category) }}</h6>
                    </td>
                    <td class="text-end">
                      <h6 class="mb-0">{{ $category->total }}</h6>
                    </td>
                    <td class="text-end" style="width: 100px;">
                      <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: {{ $total_assets > 0 ? ($category->total/$total_assets)*100 : 0 }}%"></div>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="3" class="text-center text-muted">No data available</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Stats -->
      <div class="col-md-12 col-xl-4">
        <div class="card">
          <div class="card-header">
            <h5>Quick Stats</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="bg-light-success rounded p-3 mb-3">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                      <i class="ti ti-circle-check text-success f-30"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <p class="mb-0 text-muted">Active</p>
                      <h5 class="mb-0">{{ $active_transactions }}</h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="bg-light-warning rounded p-3 mb-3">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                      <i class="ti ti-clock text-warning f-30"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <p class="mb-0 text-muted">Backup</p>
                      <h5 class="mb-0">{{ $backup_transactions }}</h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="bg-light-info rounded p-3 mb-3">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                      <i class="ti ti-device-desktop text-info f-30"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <p class="mb-0 text-muted">Standby</p>
                      <h5 class="mb-0">{{ $standby_transactions }}</h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="bg-light-primary rounded p-3 mb-3">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                      <i class="ti ti-tool text-primary f-30"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <p class="mb-0 text-muted">This Month</p>
                      <h5 class="mb-0">{{ $maintenance_this_month }}</h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif

    @if(Auth::user()->role->name == 'developer')
    <!-- Recent Activities -->
    <div class="row">
      <!-- Recent Transactions -->
      <div class="col-md-12 col-xl-6">
        <div class="card">
          <div class="card-header">
            <h5>Recent Transactions</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Asset</th>
                    <th>Employee</th>
                    <th>Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recent_transactions as $transaction)
                  <tr>
                    <td>
                      <h6 class="mb-0">{{ $transaction->code }}</h6>
                      <small class="text-muted">{{ $transaction->category }} - {{ $transaction->merk }}</small>
                    </td>
                    <td>{{ ucfirst(strtolower($transaction->nama)) }}</td>
                    <td><small>{{ date('d M Y', strtotime($transaction->assigned_date)) }}</small></td>
                    <td>
                      @if($transaction->is_active == 'active')
                        <span class="badge bg-success">Active</span>
                      @elseif($transaction->is_active == 'backup')
                        <span class="badge bg-warning">Backup</span>
                      @elseif($transaction->is_active == 'standby')
                        <span class="badge bg-info">Standby</span>
                      @else
                        <span class="badge bg-secondary">-</span>
                      @endif
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" class="text-center text-muted">No recent transactions</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            @if($recent_transactions->count() > 0)
            <div class="text-center mt-3">
              <a href="{{ url('transaction') }}" class="btn btn-sm btn-link">View All Transactions <i class="ti ti-arrow-right"></i></a>
            </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Recent Maintenances -->
      <div class="col-md-12 col-xl-6">
        <div class="card">
          <div class="card-header">
            <h5>Recent Maintenances</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Asset</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Technician</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recent_maintenances as $maintenance)
                  <tr>
                    <td>
                      <h6 class="mb-0">{{ $maintenance->code }}</h6>
                      <small class="text-muted">{{ $maintenance->category }}</small>
                    </td>
                    <td>
                      <h6 class="mb-0">{{ $maintenance->name }}</h6>
                      <small class="text-muted">{{ Str::limit($maintenance->notes, 30) }}</small>
                    </td>
                    <td><small>{{ date('d M Y', strtotime($maintenance->date)) }}</small></td>
                    <td>{{ $maintenance->technicial }}</td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" class="text-center text-muted">No recent maintenances</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            @if($recent_maintenances->count() > 0)
            <div class="text-center mt-3">
              <a href="{{ url('maintenance') }}" class="btn btn-sm btn-link">View All Maintenances <i class="ti ti-arrow-right"></i></a>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Tickets -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5>Recent Tickets</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Employee</th>
                    <th>Technician</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recent_tickets as $ticket)
                  <tr>
                    <td>
                      <h6 class="mb-0">{{ $ticket->code }}</h6>
                    </td>
                    <td>
                      <small class="text-muted">{{ Str::limit($ticket->description, 40) }}</small>
                    </td>
                    <td>{{ ucfirst(strtolower($ticket->nama)) }}</td>
                    <td>{{ $ticket->teknician }}</td>
                    <td>
                      @if($ticket->level == 'High')
                        <span class="badge bg-danger">High</span>
                      @elseif($ticket->level == 'Medium')
                        <span class="badge bg-warning">Medium</span>
                      @else
                        <span class="badge bg-info">Low</span>
                      @endif
                    </td>
                    <td>
                      @if($ticket->status == 'open')
                        <span class="badge bg-primary">Open</span>
                      @elseif($ticket->status == 'process')
                        <span class="badge bg-warning">Process</span>
                      @elseif($ticket->status == 'closed')
                        <span class="badge bg-success">Closed</span>
                      @else
                        <span class="badge bg-secondary">-</span>
                      @endif
                    </td>
                    <td><small>{{ date('d M Y', strtotime($ticket->date)) }}</small></td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="7" class="text-center text-muted">No recent tickets</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            @if($recent_tickets->count() > 0)
            <div class="text-center mt-3">
              <a href="{{ url('ticket') }}" class="btn btn-sm btn-link">View All Tickets <i class="ti ti-arrow-right"></i></a>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endif

  </div>
</div>
@endsection
