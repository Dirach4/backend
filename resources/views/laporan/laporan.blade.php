<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Kelana</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed {{ session('theme', 'light-mode') }}">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/kelanalogo.png" alt="kelanalogo" height="60" width="60">
  </div>

  <!-- Navbar -->
    @include('layouts.navigation')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    @include('layouts.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Laporan</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          @include('laporan.card')
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Laporan</h3>

              <div class="card-tools">
                <form method="GET" action="{{ route('laporan.index') }}">
                  <div class="input-group input-group-sm">
                      <input type="text" name="table_search" class="form-control" placeholder="Search Mail" value="{{ request('table_search') }}">
                      <div class="input-group-append">
                          <button type="submit" class="btn btn-primary">
                              <i class="fas fa-search"></i>
                          </button>
                      </div>
                  </div>
                </form>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
                
                <!-- btn pagination -->
                <button type="button" class="btn btn-default btn-sm">
                  <i class="fas fa-sync-alt"></i>
                </button>
                <div class="float-right">
                  {{ $reports->firstItem() }}-{{ $reports->lastItem() }}/{{ $reports->total() }}
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm" {{ $reports->onFirstPage() ? 'disabled' : '' }} onclick="window.location.href='{{ $reports->previousPageUrl() }}'">
                      <i class="fas fa-chevron-left"></i>
                    </button>
                    <button type="button" class="btn btn-default btn-sm" {{ $reports->hasMorePages() ? '' : 'disabled' }} onclick="window.location.href='{{ $reports->nextPageUrl() }}'">
                      <i class="fas fa-chevron-right"></i>
                    </button>
                  </div>
                  <!-- btn pagination -->
                </div>
                <!-- /.float-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                    @forelse ($reports as $laporan)
                      <tr>
                        <td>
                          <div class="icheck-primary">
                            <input type="checkbox" value="" id="check{{ $laporan->id }}">
                            <label for="check{{ $laporan->id }}"></label>
                          </div>
                        </td>
                        <td class="mailbox-star">
                          <a href="{{ route('bacalaporan.index', ['id' => $laporan->id]) }}" class="btn btn-block btn-primary">Lihat</a>
                          
                          @if ($laporan->status === 'masuk')
                            <a href="{{ route('laporan.proses', ['id' => $laporan->id]) }}" class="btn btn-block btn-warning">Proses</a>
                          @elseif ($laporan->status === 'proses')
                            <a href="#" class="btn btn-block btn-success" data-toggle="modal" data-target="#ketHasilModal{{ $laporan->id }}">Selesai</a>
                          @endif
                        </td>
                        <td class="mailbox-name"><a>{{ $laporan->user->name }}</a></td>
                        <td class="mailbox-subject">{{ $laporan->area_kejadian }}</td>
                        <td class="mailbox-subject">{{ $laporan->bentuk_kekerasan }}</td>
                        <td class="mailbox-subject">{{ $laporan->kronologi }}</td>
                        <td class="mailbox-date">{{ $laporan->created_at }}</td>
                      </tr>

                      <!-- Modal -->
                      <div class="modal fade" id="ketHasilModal{{ $laporan->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <form action="{{ route('laporan.selesai', $laporan->id) }}" method="POST">
                              @csrf
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Isi Keterangan Hasil</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="form-group">
                                  <label for="ket_hasil">Keterangan Hasil</label>
                                  <input type="text" class="form-control" id="ket_hasil" name="ket_hasil" required>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                    @empty
                      <tr>
                        <td colspan="7">No reports found.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
              <div class="card-body p-0">
                <div class="mailbox-controls">
                  <!-- Check all button -->
                  <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                  </button>
                  
                  <!-- btn pagination -->
                  <button type="button" class="btn btn-default btn-sm">
                    <i class="fas fa-sync-alt"></i>
                  </button>
                  <div class="float-right">
                    {{ $reports->firstItem() }}-{{ $reports->lastItem() }}/{{ $reports->total() }}
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-sm" {{ $reports->onFirstPage() ? 'disabled' : '' }} onclick="window.location.href='{{ $reports->previousPageUrl() }}'">
                        <i class="fas fa-chevron-left"></i>
                      </button>
                      <button type="button" class="btn btn-default btn-sm" {{ $reports->hasMorePages() ? '' : 'disabled' }} onclick="window.location.href='{{ $reports->nextPageUrl() }}'">
                        <i class="fas fa-chevron-right"></i>
                      </button>
                    </div>
                    <!-- btn pagination -->
                  </div>
                  <!-- /.float-right -->
                </div>
              </div>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
</div>
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

</body>
</html>
