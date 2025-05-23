@extends('layouts.app')
@section('content')
  <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin-top: 2rem;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
        }
        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .status-badge {
            font-weight: normal;
        }.list-group-item{
            font-size: 14px
        }.badge{
            background: rgba(150, 226, 37, 0.288);
            color: green;
        
        }
    </style>
</head>
<body>
    <div class="container-fluied">
        <div class="row">
            <div class="col-xl-6">
                  <div class="card">
            <div class="card-header bg-grey pt-3 pb-3">
                <h5 class="mb-0">Email</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item py-3">
                    Email Address
                    <div>
                        <a href="mailto:saeeraethon@gmail.com" class="text-decoration-none">saeeraethon@gmail.com</a>
                    </div>
                </li>
                <li class="list-group-item py-3">
                    Email Status
                    <div>
                        <i class="fas fa-info-circle text-info me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="More info on Email Statuses"></i>
                        <span class="badge  status-badge ">Valid</span>
                    </div>
                </li>
                <li class="list-group-item py-3">
                    Email Syntax Format
                    <div>
                        <span class="badge   status-badge"><i class="fas fa-check me-1"></i>Valid</span>
                    </div>
                </li>
                <li class="list-group-item py-3">
                    Mailbox Server Status
                    <div>
                        <span class="badge  status-badge"><i class="fas fa-check me-1"></i>Valid</span>
                    </div>
                </li>
                <li class="list-group-item py-3">
                    Mailbox Type
                    <div>
                        <span class="badge bg-warning status-badge">Webmail</span>
                    </div>
                </li>
                <li class="list-group-item py-3">
                    Domain
                    <div>
                        <span>gmail.com</span>
                    </div>
                </li>
            </ul>
            <div class="card-footer bg-success-subtle border-success text-success py-3">
                <i class="fas fa-exclamation-circle me-2"></i>
                Email is active and reachable. <a href="#" class="alert-link text-success text-decoration-none">More information on Email Statuses.</a>
            </div>
        </div>
            </div>
             <div class="col-xl-6"></div>
        </div>
      
    </div>

 
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

@endsection


