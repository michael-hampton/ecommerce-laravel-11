@extends('layouts.admin')
@section('content')
    <style>
        .card {
            margin-bottom: 1.5rem;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-light" id="dash-daterange">
                            <span class="input-group-text bg-primary border-primary text-white">
                                                <i class="mdi mdi-calendar-range font-13"></i>
                                            </span>
                        </div>
                        <a href="javascript: void(0);" class="btn btn-primary ms-2">
                            <i class="mdi mdi-autorenew"></i>
                        </a>
                        <a href="javascript: void(0);" class="btn btn-primary ms-1">
                            <i class="mdi mdi-filter-variant"></i>
                        </a>
                    </form>
                </div>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-5 col-lg-6">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="icon-shopping-bag"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Orders</h5>
                            <h3 class="mt-3 mb-3">{{$dashboardData[0]->Total}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="icon-dollar-sign"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Amount</h5>
                            <h3 class="mt-3 mb-3">{{$dashboardData[0]->TotalAmount}}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="icon-shopping-bag"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Pending Orders</h5>
                            <h3 class="mt-3 mb-3">{{$dashboardData[0]->TotalOrdered}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="icon-dollar-sign"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Pending Orders Amount</h5>
                            <h3 class="mt-3 mb-3">{{$dashboardData[0]->TotalOrderedAmount}}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="icon-shopping-bag"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Delivered Orders</h5>
                            <h3 class="mt-3 mb-3">{{$dashboardData[0]->TotalDelivered}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="icon-dollar-sign"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Delivered Orders
                                Amount</h5>
                            <h3 class="mt-3 mb-3">{{$dashboardData[0]->TotalDeliveredAmount}}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="icon-shopping-bag"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Cancelled Orders</h5>
                            <h3 class="mt-3 mb-3">{{$dashboardData[0]->TotalCancelled}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="icon-dollar-sign"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Cancelled Orders
                                Amount</h5>
                            <h3 class="mt-3 mb-3">{{$dashboardData[0]->TotalCancelledAmount}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7 col-lg-6">
            <div class="card card-h-100">
                <div class="d-flex card-header justify-content-between align-items-center">
                    <h4 class="header-title">Earnings Revenue</h4>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div dir="ltr">
                        <div id="high-performing-product" class="apex-charts" data-colors="#727cf5,#91a6bd40"
                             style="min-height: 256px;">
                            <div id="apexchartsng9qcsee"
                                 class="apexcharts-canvas apexchartsng9qcsee apexcharts-theme-light"
                                 style="width: 649px; height: 256px;">
                                <svg id="SvgjsSvg2409" width="649" height="256" xmlns="http://www.w3.org/2000/svg"
                                     version="1.1"
                                     class="apexcharts-svg" xmlns:data="ApexChartsNS"
                                     transform="translate(0, 0)" style="background: transparent;">
                                    <foreignObject x="0" y="0" width="649" height="256">
                                        <div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml"
                                             style="max-height: 128px;"></div>
                                    </foreignObject>
                                    <g id="SvgjsG2541" class="apexcharts-yaxis" rel="0"
                                       transform="translate(7.399999618530273, 0)">
                                        <g id="SvgjsG2542" class="apexcharts-yaxis-texts-g">
                                            <text id="SvgjsText2544" font-family="Helvetica, Arial, sans-serif" x="20"
                                                  y="31.5" text-anchor="end" dominant-baseline="auto" font-size="11px"
                                                  font-weight="400" fill="#373d3f"
                                                  class="apexcharts-text apexcharts-yaxis-label "
                                                  style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan2545">200k</tspan>
                                                <title>200k</title></text>
                                            <text id="SvgjsText2547" font-family="Helvetica, Arial, sans-serif" x="20"
                                                  y="68.5224" text-anchor="end" dominant-baseline="auto"
                                                  font-size="11px" font-weight="400" fill="#373d3f"
                                                  class="apexcharts-text apexcharts-yaxis-label "
                                                  style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan2548">160k</tspan>
                                                <title>160k</title></text>
                                            <text id="SvgjsText2550" font-family="Helvetica, Arial, sans-serif" x="20"
                                                  y="105.54480000000001" text-anchor="end" dominant-baseline="auto"
                                                  font-size="11px" font-weight="400" fill="#373d3f"
                                                  class="apexcharts-text apexcharts-yaxis-label "
                                                  style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan2551">120k</tspan>
                                                <title>120k</title></text>
                                            <text id="SvgjsText2553" font-family="Helvetica, Arial, sans-serif" x="20"
                                                  y="142.5672" text-anchor="end" dominant-baseline="auto"
                                                  font-size="11px" font-weight="400" fill="#373d3f"
                                                  class="apexcharts-text apexcharts-yaxis-label "
                                                  style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan2554">80k</tspan>
                                                <title>80k</title></text>
                                            <text id="SvgjsText2556" font-family="Helvetica, Arial, sans-serif" x="20"
                                                  y="179.58960000000002" text-anchor="end" dominant-baseline="auto"
                                                  font-size="11px" font-weight="400" fill="#373d3f"
                                                  class="apexcharts-text apexcharts-yaxis-label "
                                                  style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan2557">40k</tspan>
                                                <title>40k</title></text>
                                            <text id="SvgjsText2559" font-family="Helvetica, Arial, sans-serif" x="20"
                                                  y="216.61200000000002" text-anchor="end" dominant-baseline="auto"
                                                  font-size="11px" font-weight="400" fill="#373d3f"
                                                  class="apexcharts-text apexcharts-yaxis-label "
                                                  style="font-family: Helvetica, Arial, sans-serif;">
                                                <tspan id="SvgjsTspan2560">0k</tspan>
                                                <title>0k</title></text>
                                        </g>
                                    </g>
                                    <g id="SvgjsG2411" class="apexcharts-inner apexcharts-graphical"
                                       transform="translate(40.39999961853027, 30)">
                                        <defs id="SvgjsDefs2410">
                                            <linearGradient id="SvgjsLinearGradient2414" x1="0" y1="0" x2="0" y2="1">
                                                <stop id="SvgjsStop2415" stop-opacity="0.4"
                                                      stop-color="rgba(216,227,240,0.4)" offset="0"></stop>
                                                <stop id="SvgjsStop2416" stop-opacity="0.5"
                                                      stop-color="rgba(190,209,230,0.5)" offset="1"></stop>
                                                <stop id="SvgjsStop2417" stop-opacity="0.5"
                                                      stop-color="rgba(190,209,230,0.5)" offset="1"></stop>
                                            </linearGradient>
                                            <clipPath id="gridRectMaskng9qcsee">
                                                <rect id="SvgjsRect2419" width="612.6000003814697" height="189.112"
                                                      x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0"
                                                      stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="forecastMaskng9qcsee"></clipPath>
                                            <clipPath id="nonForecastMaskng9qcsee"></clipPath>
                                            <clipPath id="gridRectMarkerMaskng9qcsee">
                                                <rect id="SvgjsRect2420" width="612.6000003814697" height="189.112"
                                                      x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0"
                                                      stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                        </defs>
                                        <rect id="SvgjsRect2418" width="10.143333339691162" height="185.112"
                                              x="172.28329758644105" y="0" rx="0" ry="0" opacity="1" stroke-width="0"
                                              stroke-dasharray="3" fill="url(#SvgjsLinearGradient2414)"
                                              class="apexcharts-xcrosshairs" y2="185.112" filter="none"
                                              fill-opacity="0.9" x1="172.28329758644105" x2="172.28329758644105"></rect>
                                        <line id="SvgjsLine2480" x1="0" y1="186.112" x2="0" y2="192.112"
                                              stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt"
                                              class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine2481" x1="50.71666669845581" y1="186.112"
                                              x2="50.71666669845581" y2="192.112" stroke="#e0e0e0" stroke-dasharray="0"
                                              stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine2482" x1="101.43333339691162" y1="186.112"
                                              x2="101.43333339691162" y2="192.112" stroke="#e0e0e0" stroke-dasharray="0"
                                              stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine2483" x1="152.15000009536743" y1="186.112"
                                              x2="152.15000009536743" y2="192.112" stroke="#e0e0e0" stroke-dasharray="0"
                                              stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine2484" x1="202.86666679382324" y1="186.112"
                                              x2="202.86666679382324" y2="192.112" stroke="#e0e0e0" stroke-dasharray="0"
                                              stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine2485" x1="253.58333349227905" y1="186.112"
                                              x2="253.58333349227905" y2="192.112" stroke="#e0e0e0" stroke-dasharray="0"
                                              stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine2486" x1="304.30000019073486" y1="186.112"
                                              x2="304.30000019073486" y2="192.112" stroke="#e0e0e0" stroke-dasharray="0"
                                              stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine2487" x1="355.0166668891907" y1="186.112"
                                              x2="355.0166668891907" y2="192.112" stroke="#e0e0e0" stroke-dasharray="0"
                                              stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine2488" x1="405.7333335876465" y1="186.112"
                                              x2="405.7333335876465" y2="192.112" stroke="#e0e0e0" stroke-dasharray="0"
                                              stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine2489" x1="456.4500002861023" y1="186.112"
                                              x2="456.4500002861023" y2="192.112" stroke="#e0e0e0" stroke-dasharray="0"
                                              stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine2490" x1="507.1666669845581" y1="186.112"
                                              x2="507.1666669845581" y2="192.112" stroke="#e0e0e0" stroke-dasharray="0"
                                              stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine2491" x1="557.8833336830139" y1="186.112"
                                              x2="557.8833336830139" y2="192.112" stroke="#e0e0e0" stroke-dasharray="0"
                                              stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine2492" x1="608.6000003814697" y1="186.112"
                                              x2="608.6000003814697" y2="192.112" stroke="#e0e0e0" stroke-dasharray="0"
                                              stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                        <g id="SvgjsG2476" class="apexcharts-grid">
                                            <g id="SvgjsG2477" class="apexcharts-gridlines-horizontal">
                                                <line id="SvgjsLine2494" x1="0" y1="37.0224" x2="608.6000003814697"
                                                      y2="37.0224" stroke="#e0e0e0" stroke-dasharray="0"
                                                      stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine2495" x1="0" y1="74.0448" x2="608.6000003814697"
                                                      y2="74.0448" stroke="#e0e0e0" stroke-dasharray="0"
                                                      stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine2496" x1="0" y1="111.06719999999999"
                                                      x2="608.6000003814697" y2="111.06719999999999" stroke="#e0e0e0"
                                                      stroke-dasharray="0" stroke-linecap="butt"
                                                      class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine2497" x1="0" y1="148.0896" x2="608.6000003814697"
                                                      y2="148.0896" stroke="#e0e0e0" stroke-dasharray="0"
                                                      stroke-linecap="butt" class="apexcharts-gridline"></line>
                                            </g>
                                            <g id="SvgjsG2478" class="apexcharts-gridlines-vertical"></g>
                                            <line id="SvgjsLine2500" x1="0" y1="185.112" x2="608.6000003814697"
                                                  y2="185.112" stroke="transparent" stroke-dasharray="0"
                                                  stroke-linecap="butt"></line>
                                            <line id="SvgjsLine2499" x1="0" y1="1" x2="0" y2="185.112"
                                                  stroke="transparent" stroke-dasharray="0"
                                                  stroke-linecap="butt"></line>
                                        </g>
                                        <g id="SvgjsG2479" class="apexcharts-grid-borders">
                                            <line id="SvgjsLine2493" x1="0" y1="0" x2="608.6000003814697" y2="0"
                                                  stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt"
                                                  class="apexcharts-gridline"></line>
                                            <line id="SvgjsLine2498" x1="0" y1="185.112" x2="608.6000003814697"
                                                  y2="185.112" stroke="#e0e0e0" stroke-dasharray="0"
                                                  stroke-linecap="butt" class="apexcharts-gridline"></line>
                                        </g>
                                        <g id="SvgjsG2421" class="apexcharts-bar-series apexcharts-plot-series">
                                            <g id="SvgjsG2422" class="apexcharts-series" seriesName="Actual" rel="1"
                                               data:realIndex="0">
                                                <path id="SvgjsPath2426"
                                                      d="M 20.286666679382325 185.113 L 20.286666679382325 124.95160000000001 L 30.43000001907349 124.95160000000001 L 30.43000001907349 185.113 z"
                                                      fill="rgba(114,124,245,1)" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="0"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 20.286666679382325 185.113 L 20.286666679382325 124.95160000000001 L 30.43000001907349 124.95160000000001 L 30.43000001907349 185.113 z"
                                                      pathFrom="M 20.286666679382325 185.113 L 20.286666679382325 185.113 L 30.43000001907349 185.113 L 30.43000001907349 185.113 L 30.43000001907349 185.113 L 30.43000001907349 185.113 L 30.43000001907349 185.113 L 20.286666679382325 185.113 z"
                                                      cy="124.95060000000001" cx="71.00333337783813" j="0" val="65"
                                                      barHeight="60.16139999999999"
                                                      barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2428"
                                                      d="M 71.00333337783813 185.113 L 71.00333337783813 130.50496 L 81.1466667175293 130.50496 L 81.1466667175293 185.113 z"
                                                      fill="rgba(114,124,245,1)" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="0"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 71.00333337783813 185.113 L 71.00333337783813 130.50496 L 81.1466667175293 130.50496 L 81.1466667175293 185.113 z"
                                                      pathFrom="M 71.00333337783813 185.113 L 71.00333337783813 185.113 L 81.1466667175293 185.113 L 81.1466667175293 185.113 L 81.1466667175293 185.113 L 81.1466667175293 185.113 L 81.1466667175293 185.113 L 71.00333337783813 185.113 z"
                                                      cy="130.50396" cx="121.72000007629394" j="1" val="59"
                                                      barHeight="54.608039999999995"
                                                      barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2430"
                                                      d="M 121.72000007629394 185.113 L 121.72000007629394 111.0682 L 131.8633334159851 111.0682 L 131.8633334159851 185.113 z"
                                                      fill="rgba(114,124,245,1)" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="0"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 121.72000007629394 185.113 L 121.72000007629394 111.0682 L 131.8633334159851 111.0682 L 131.8633334159851 185.113 z"
                                                      pathFrom="M 121.72000007629394 185.113 L 121.72000007629394 185.113 L 131.8633334159851 185.113 L 131.8633334159851 185.113 L 131.8633334159851 185.113 L 131.8633334159851 185.113 L 131.8633334159851 185.113 L 121.72000007629394 185.113 z"
                                                      cy="111.0672" cx="172.43666677474977" j="2" val="80"
                                                      barHeight="74.0448" barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2432"
                                                      d="M 172.43666677474977 185.113 L 172.43666677474977 110.14264 L 182.58000011444094 110.14264 L 182.58000011444094 185.113 z"
                                                      fill="rgba(114,124,245,1)" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="0"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 172.43666677474977 185.113 L 172.43666677474977 110.14264 L 182.58000011444094 110.14264 L 182.58000011444094 185.113 z"
                                                      pathFrom="M 172.43666677474977 185.113 L 172.43666677474977 185.113 L 182.58000011444094 185.113 L 182.58000011444094 185.113 L 182.58000011444094 185.113 L 182.58000011444094 185.113 L 182.58000011444094 185.113 L 172.43666677474977 185.113 z"
                                                      cy="110.14164" cx="223.15333347320558" j="3" val="81"
                                                      barHeight="74.97036" barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2434"
                                                      d="M 223.15333347320558 185.113 L 223.15333347320558 133.28164 L 233.29666681289675 133.28164 L 233.29666681289675 185.113 z"
                                                      fill="rgba(114,124,245,1)" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="0"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 223.15333347320558 185.113 L 223.15333347320558 133.28164 L 233.29666681289675 133.28164 L 233.29666681289675 185.113 z"
                                                      pathFrom="M 223.15333347320558 185.113 L 223.15333347320558 185.113 L 233.29666681289675 185.113 L 233.29666681289675 185.113 L 233.29666681289675 185.113 L 233.29666681289675 185.113 L 233.29666681289675 185.113 L 223.15333347320558 185.113 z"
                                                      cy="133.28064" cx="273.8700001716614" j="4" val="56"
                                                      barHeight="51.83136" barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2436"
                                                      d="M 273.8700001716614 185.113 L 273.8700001716614 102.73816000000001 L 284.0133335113525 102.73816000000001 L 284.0133335113525 185.113 z"
                                                      fill="rgba(114,124,245,1)" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="0"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 273.8700001716614 185.113 L 273.8700001716614 102.73816000000001 L 284.0133335113525 102.73816000000001 L 284.0133335113525 185.113 z"
                                                      pathFrom="M 273.8700001716614 185.113 L 273.8700001716614 185.113 L 284.0133335113525 185.113 L 284.0133335113525 185.113 L 284.0133335113525 185.113 L 284.0133335113525 185.113 L 284.0133335113525 185.113 L 273.8700001716614 185.113 z"
                                                      cy="102.73716" cx="324.5866668701172" j="5" val="89"
                                                      barHeight="82.37483999999999"
                                                      barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2438"
                                                      d="M 324.5866668701172 185.113 L 324.5866668701172 148.0906 L 334.73000020980834 148.0906 L 334.73000020980834 185.113 z"
                                                      fill="rgba(114,124,245,1)" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="0"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 324.5866668701172 185.113 L 324.5866668701172 148.0906 L 334.73000020980834 148.0906 L 334.73000020980834 185.113 z"
                                                      pathFrom="M 324.5866668701172 185.113 L 324.5866668701172 185.113 L 334.73000020980834 185.113 L 334.73000020980834 185.113 L 334.73000020980834 185.113 L 334.73000020980834 185.113 L 334.73000020980834 185.113 L 324.5866668701172 185.113 z"
                                                      cy="148.0896" cx="375.303333568573" j="6" val="40"
                                                      barHeight="37.0224" barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2440"
                                                      d="M 375.303333568573 185.113 L 375.303333568573 155.49508 L 385.44666690826415 155.49508 L 385.44666690826415 185.113 z"
                                                      fill="rgba(114,124,245,1)" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="0"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 375.303333568573 185.113 L 375.303333568573 155.49508 L 385.44666690826415 155.49508 L 385.44666690826415 185.113 z"
                                                      pathFrom="M 375.303333568573 185.113 L 375.303333568573 185.113 L 385.44666690826415 185.113 L 385.44666690826415 185.113 L 385.44666690826415 185.113 L 385.44666690826415 185.113 L 385.44666690826415 185.113 L 375.303333568573 185.113 z"
                                                      cy="155.49408" cx="426.0200002670288" j="7" val="32"
                                                      barHeight="29.617919999999998"
                                                      barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2442"
                                                      d="M 426.0200002670288 185.113 L 426.0200002670288 124.95160000000001 L 436.16333360671996 124.95160000000001 L 436.16333360671996 185.113 z"
                                                      fill="rgba(114,124,245,1)" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="0"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 426.0200002670288 185.113 L 426.0200002670288 124.95160000000001 L 436.16333360671996 124.95160000000001 L 436.16333360671996 185.113 z"
                                                      pathFrom="M 426.0200002670288 185.113 L 426.0200002670288 185.113 L 436.16333360671996 185.113 L 436.16333360671996 185.113 L 436.16333360671996 185.113 L 436.16333360671996 185.113 L 436.16333360671996 185.113 L 426.0200002670288 185.113 z"
                                                      cy="124.95060000000001" cx="476.73666696548463" j="8" val="65"
                                                      barHeight="60.16139999999999"
                                                      barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2444"
                                                      d="M 476.73666696548463 185.113 L 476.73666696548463 130.50496 L 486.88000030517577 130.50496 L 486.88000030517577 185.113 z"
                                                      fill="rgba(114,124,245,1)" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="0"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 476.73666696548463 185.113 L 476.73666696548463 130.50496 L 486.88000030517577 130.50496 L 486.88000030517577 185.113 z"
                                                      pathFrom="M 476.73666696548463 185.113 L 476.73666696548463 185.113 L 486.88000030517577 185.113 L 486.88000030517577 185.113 L 486.88000030517577 185.113 L 486.88000030517577 185.113 L 486.88000030517577 185.113 L 476.73666696548463 185.113 z"
                                                      cy="130.50396" cx="527.4533336639404" j="9" val="59"
                                                      barHeight="54.608039999999995"
                                                      barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2446"
                                                      d="M 527.4533336639404 185.113 L 527.4533336639404 111.0682 L 537.5966670036315 111.0682 L 537.5966670036315 185.113 z"
                                                      fill="rgba(114,124,245,1)" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="0"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 527.4533336639404 185.113 L 527.4533336639404 111.0682 L 537.5966670036315 111.0682 L 537.5966670036315 185.113 z"
                                                      pathFrom="M 527.4533336639404 185.113 L 527.4533336639404 185.113 L 537.5966670036315 185.113 L 537.5966670036315 185.113 L 537.5966670036315 185.113 L 537.5966670036315 185.113 L 537.5966670036315 185.113 L 527.4533336639404 185.113 z"
                                                      cy="111.0672" cx="578.1700003623962" j="10" val="80"
                                                      barHeight="74.0448" barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2448"
                                                      d="M 578.1700003623962 185.113 L 578.1700003623962 110.14264 L 588.3133337020873 110.14264 L 588.3133337020873 185.113 z"
                                                      fill="rgba(114,124,245,1)" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="0"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 578.1700003623962 185.113 L 578.1700003623962 110.14264 L 588.3133337020873 110.14264 L 588.3133337020873 185.113 z"
                                                      pathFrom="M 578.1700003623962 185.113 L 578.1700003623962 185.113 L 588.3133337020873 185.113 L 588.3133337020873 185.113 L 588.3133337020873 185.113 L 588.3133337020873 185.113 L 588.3133337020873 185.113 L 578.1700003623962 185.113 z"
                                                      cy="110.14164" cx="628.886667060852" j="11" val="81"
                                                      barHeight="74.97036" barWidth="10.143333339691162"></path>
                                                <g id="SvgjsG2424" class="apexcharts-bar-goals-markers">
                                                    <g id="SvgjsG2425" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2427" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2429" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2431" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2433" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2435" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2437" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2439" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2441" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2443" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2445" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2447" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                </g>
                                            </g>
                                            <g id="SvgjsG2449" class="apexcharts-series" seriesName="Projection" rel="2"
                                               data:realIndex="1">
                                                <path id="SvgjsPath2453"
                                                      d="M 20.286666679382325 124.95260000000002 L 20.286666679382325 42.57776000000002 L 30.43000001907349 42.57776000000002 L 30.43000001907349 124.95260000000002 z"
                                                      fill="#91a6bd40" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="1"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 20.286666679382325 124.95260000000002 L 20.286666679382325 42.57776000000002 L 30.43000001907349 42.57776000000002 L 30.43000001907349 124.95260000000002 z"
                                                      pathFrom="M 20.286666679382325 124.95260000000002 L 20.286666679382325 124.95260000000002 L 30.43000001907349 124.95260000000002 L 30.43000001907349 124.95260000000002 L 30.43000001907349 124.95260000000002 L 30.43000001907349 124.95260000000002 L 30.43000001907349 124.95260000000002 L 20.286666679382325 124.95260000000002 z"
                                                      cy="42.57676000000002" cx="71.00333337783813" j="0" val="89"
                                                      barHeight="82.37483999999999"
                                                      barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2455"
                                                      d="M 71.00333337783813 130.50596000000002 L 71.00333337783813 93.48356000000001 L 81.1466667175293 93.48356000000001 L 81.1466667175293 130.50596000000002 z"
                                                      fill="#91a6bd40" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="1"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 71.00333337783813 130.50596000000002 L 71.00333337783813 93.48356000000001 L 81.1466667175293 93.48356000000001 L 81.1466667175293 130.50596000000002 z"
                                                      pathFrom="M 71.00333337783813 130.50596000000002 L 71.00333337783813 130.50596000000002 L 81.1466667175293 130.50596000000002 L 81.1466667175293 130.50596000000002 L 81.1466667175293 130.50596000000002 L 81.1466667175293 130.50596000000002 L 81.1466667175293 130.50596000000002 L 71.00333337783813 130.50596000000002 z"
                                                      cy="93.48256" cx="121.72000007629394" j="1" val="40"
                                                      barHeight="37.0224" barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2457"
                                                      d="M 121.72000007629394 111.06920000000001 L 121.72000007629394 81.45128000000001 L 131.8633334159851 81.45128000000001 L 131.8633334159851 111.06920000000001 z"
                                                      fill="#91a6bd40" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="1"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 121.72000007629394 111.06920000000001 L 121.72000007629394 81.45128000000001 L 131.8633334159851 81.45128000000001 L 131.8633334159851 111.06920000000001 z"
                                                      pathFrom="M 121.72000007629394 111.06920000000001 L 121.72000007629394 111.06920000000001 L 131.8633334159851 111.06920000000001 L 131.8633334159851 111.06920000000001 L 131.8633334159851 111.06920000000001 L 131.8633334159851 111.06920000000001 L 131.8633334159851 111.06920000000001 L 121.72000007629394 111.06920000000001 z"
                                                      cy="81.45028" cx="172.43666677474977" j="2" val="32"
                                                      barHeight="29.617919999999998"
                                                      barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2459"
                                                      d="M 172.43666677474977 110.14364 L 172.43666677474977 49.982240000000004 L 182.58000011444094 49.982240000000004 L 182.58000011444094 110.14364 z"
                                                      fill="#91a6bd40" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="1"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 172.43666677474977 110.14364 L 172.43666677474977 49.982240000000004 L 182.58000011444094 49.982240000000004 L 182.58000011444094 110.14364 z"
                                                      pathFrom="M 172.43666677474977 110.14364 L 172.43666677474977 110.14364 L 182.58000011444094 110.14364 L 182.58000011444094 110.14364 L 182.58000011444094 110.14364 L 182.58000011444094 110.14364 L 182.58000011444094 110.14364 L 172.43666677474977 110.14364 z"
                                                      cy="49.98124000000001" cx="223.15333347320558" j="3" val="65"
                                                      barHeight="60.16139999999999"
                                                      barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2461"
                                                      d="M 223.15333347320558 133.28264000000001 L 223.15333347320558 78.67460000000003 L 233.29666681289675 78.67460000000003 L 233.29666681289675 133.28264000000001 z"
                                                      fill="#91a6bd40" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="1"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 223.15333347320558 133.28264000000001 L 223.15333347320558 78.67460000000003 L 233.29666681289675 78.67460000000003 L 233.29666681289675 133.28264000000001 z"
                                                      pathFrom="M 223.15333347320558 133.28264000000001 L 223.15333347320558 133.28264000000001 L 233.29666681289675 133.28264000000001 L 233.29666681289675 133.28264000000001 L 233.29666681289675 133.28264000000001 L 233.29666681289675 133.28264000000001 L 233.29666681289675 133.28264000000001 L 223.15333347320558 133.28264000000001 z"
                                                      cy="78.67360000000002" cx="273.8700001716614" j="4" val="59"
                                                      barHeight="54.608039999999995"
                                                      barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2463"
                                                      d="M 273.8700001716614 102.73916000000001 L 273.8700001716614 28.694360000000014 L 284.0133335113525 28.694360000000014 L 284.0133335113525 102.73916000000001 z"
                                                      fill="#91a6bd40" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="1"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 273.8700001716614 102.73916000000001 L 273.8700001716614 28.694360000000014 L 284.0133335113525 28.694360000000014 L 284.0133335113525 102.73916000000001 z"
                                                      pathFrom="M 273.8700001716614 102.73916000000001 L 273.8700001716614 102.73916000000001 L 284.0133335113525 102.73916000000001 L 284.0133335113525 102.73916000000001 L 284.0133335113525 102.73916000000001 L 284.0133335113525 102.73916000000001 L 284.0133335113525 102.73916000000001 L 273.8700001716614 102.73916000000001 z"
                                                      cy="28.693360000000013" cx="324.5866668701172" j="5" val="80"
                                                      barHeight="74.0448" barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2465"
                                                      d="M 324.5866668701172 148.0916 L 324.5866668701172 73.12124 L 334.73000020980834 73.12124 L 334.73000020980834 148.0916 z"
                                                      fill="#91a6bd40" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="1"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 324.5866668701172 148.0916 L 324.5866668701172 73.12124 L 334.73000020980834 73.12124 L 334.73000020980834 148.0916 z"
                                                      pathFrom="M 324.5866668701172 148.0916 L 324.5866668701172 148.0916 L 334.73000020980834 148.0916 L 334.73000020980834 148.0916 L 334.73000020980834 148.0916 L 334.73000020980834 148.0916 L 334.73000020980834 148.0916 L 324.5866668701172 148.0916 z"
                                                      cy="73.12024" cx="375.303333568573" j="6" val="81"
                                                      barHeight="74.97036" barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2467"
                                                      d="M 375.303333568573 155.49608 L 375.303333568573 103.66472000000002 L 385.44666690826415 103.66472000000002 L 385.44666690826415 155.49608 z"
                                                      fill="#91a6bd40" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="1"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 375.303333568573 155.49608 L 375.303333568573 103.66472000000002 L 385.44666690826415 103.66472000000002 L 385.44666690826415 155.49608 z"
                                                      pathFrom="M 375.303333568573 155.49608 L 375.303333568573 155.49608 L 385.44666690826415 155.49608 L 385.44666690826415 155.49608 L 385.44666690826415 155.49608 L 385.44666690826415 155.49608 L 385.44666690826415 155.49608 L 375.303333568573 155.49608 z"
                                                      cy="103.66372000000001" cx="426.0200002670288" j="7" val="56"
                                                      barHeight="51.83136" barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2469"
                                                      d="M 426.0200002670288 124.95260000000002 L 426.0200002670288 42.57776000000002 L 436.16333360671996 42.57776000000002 L 436.16333360671996 124.95260000000002 z"
                                                      fill="#91a6bd40" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="1"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 426.0200002670288 124.95260000000002 L 426.0200002670288 42.57776000000002 L 436.16333360671996 42.57776000000002 L 436.16333360671996 124.95260000000002 z"
                                                      pathFrom="M 426.0200002670288 124.95260000000002 L 426.0200002670288 124.95260000000002 L 436.16333360671996 124.95260000000002 L 436.16333360671996 124.95260000000002 L 436.16333360671996 124.95260000000002 L 436.16333360671996 124.95260000000002 L 436.16333360671996 124.95260000000002 L 426.0200002670288 124.95260000000002 z"
                                                      cy="42.57676000000002" cx="476.73666696548463" j="8" val="89"
                                                      barHeight="82.37483999999999"
                                                      barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2471"
                                                      d="M 476.73666696548463 130.50596000000002 L 476.73666696548463 93.48356000000001 L 486.88000030517577 93.48356000000001 L 486.88000030517577 130.50596000000002 z"
                                                      fill="#91a6bd40" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="1"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 476.73666696548463 130.50596000000002 L 476.73666696548463 93.48356000000001 L 486.88000030517577 93.48356000000001 L 486.88000030517577 130.50596000000002 z"
                                                      pathFrom="M 476.73666696548463 130.50596000000002 L 476.73666696548463 130.50596000000002 L 486.88000030517577 130.50596000000002 L 486.88000030517577 130.50596000000002 L 486.88000030517577 130.50596000000002 L 486.88000030517577 130.50596000000002 L 486.88000030517577 130.50596000000002 L 476.73666696548463 130.50596000000002 z"
                                                      cy="93.48256" cx="527.4533336639404" j="9" val="40"
                                                      barHeight="37.0224" barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2473"
                                                      d="M 527.4533336639404 111.06920000000001 L 527.4533336639404 50.90780000000001 L 537.5966670036315 50.90780000000001 L 537.5966670036315 111.06920000000001 z"
                                                      fill="#91a6bd40" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="1"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 527.4533336639404 111.06920000000001 L 527.4533336639404 50.90780000000001 L 537.5966670036315 50.90780000000001 L 537.5966670036315 111.06920000000001 z"
                                                      pathFrom="M 527.4533336639404 111.06920000000001 L 527.4533336639404 111.06920000000001 L 537.5966670036315 111.06920000000001 L 537.5966670036315 111.06920000000001 L 537.5966670036315 111.06920000000001 L 537.5966670036315 111.06920000000001 L 537.5966670036315 111.06920000000001 L 527.4533336639404 111.06920000000001 z"
                                                      cy="50.90680000000001" cx="578.1700003623962" j="10" val="65"
                                                      barHeight="60.16139999999999"
                                                      barWidth="10.143333339691162"></path>
                                                <path id="SvgjsPath2475"
                                                      d="M 578.1700003623962 110.14364 L 578.1700003623962 55.5356 L 588.3133337020873 55.5356 L 588.3133337020873 110.14364 z"
                                                      fill="#91a6bd40" fill-opacity="1" stroke-opacity="1"
                                                      stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                      class="apexcharts-bar-area" index="1"
                                                      clip-path="url(#gridRectMaskng9qcsee)"
                                                      pathTo="M 578.1700003623962 110.14364 L 578.1700003623962 55.5356 L 588.3133337020873 55.5356 L 588.3133337020873 110.14364 z"
                                                      pathFrom="M 578.1700003623962 110.14364 L 578.1700003623962 110.14364 L 588.3133337020873 110.14364 L 588.3133337020873 110.14364 L 588.3133337020873 110.14364 L 588.3133337020873 110.14364 L 588.3133337020873 110.14364 L 578.1700003623962 110.14364 z"
                                                      cy="55.534600000000005" cx="628.886667060852" j="11" val="59"
                                                      barHeight="54.608039999999995"
                                                      barWidth="10.143333339691162"></path>
                                                <g id="SvgjsG2451" class="apexcharts-bar-goals-markers">
                                                    <g id="SvgjsG2452" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2454" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2456" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2458" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2460" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2462" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2464" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2466" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2468" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2470" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2472" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                    <g id="SvgjsG2474" className="apexcharts-bar-goals-groups"
                                                       class="apexcharts-hidden-element-shown"
                                                       clip-path="url(#gridRectMarkerMaskng9qcsee)"></g>
                                                </g>
                                            </g>
                                            <g id="SvgjsG2423" class="apexcharts-datalabels" data:realIndex="0"></g>
                                            <g id="SvgjsG2450" class="apexcharts-datalabels" data:realIndex="1"></g>
                                        </g>
                                        <line id="SvgjsLine2501" x1="0" y1="0" x2="608.6000003814697" y2="0"
                                              stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                              stroke-linecap="butt" class="apexcharts-ycrosshairs"></line>
                                        <line id="SvgjsLine2502" x1="0" y1="0" x2="608.6000003814697" y2="0"
                                              stroke-dasharray="0" stroke-width="0" stroke-linecap="butt"
                                              class="apexcharts-ycrosshairs-hidden"></line>
                                        <g id="SvgjsG2503" class="apexcharts-xaxis" transform="translate(0, 0)">
                                            <g id="SvgjsG2504" class="apexcharts-xaxis-texts-g"
                                               transform="translate(0, -4)">
                                                <text id="SvgjsText2506" font-family="Helvetica, Arial, sans-serif"
                                                      x="25.358333349227905" y="214.112" text-anchor="middle"
                                                      dominant-baseline="auto" font-size="12px" font-weight="400"
                                                      fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                      style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan2507">Jan</tspan>
                                                    <title>Jan</title></text>
                                                <text id="SvgjsText2509" font-family="Helvetica, Arial, sans-serif"
                                                      x="76.07500004768372" y="214.112" text-anchor="middle"
                                                      dominant-baseline="auto" font-size="12px" font-weight="400"
                                                      fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                      style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan2510">Feb</tspan>
                                                    <title>Feb</title></text>
                                                <text id="SvgjsText2512" font-family="Helvetica, Arial, sans-serif"
                                                      x="126.79166674613953" y="214.112" text-anchor="middle"
                                                      dominant-baseline="auto" font-size="12px" font-weight="400"
                                                      fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                      style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan2513">Mar</tspan>
                                                    <title>Mar</title></text>
                                                <text id="SvgjsText2515" font-family="Helvetica, Arial, sans-serif"
                                                      x="177.50833344459534" y="214.112" text-anchor="middle"
                                                      dominant-baseline="auto" font-size="12px" font-weight="400"
                                                      fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                      style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan2516">Apr</tspan>
                                                    <title>Apr</title></text>
                                                <text id="SvgjsText2518" font-family="Helvetica, Arial, sans-serif"
                                                      x="228.22500014305115" y="214.112" text-anchor="middle"
                                                      dominant-baseline="auto" font-size="12px" font-weight="400"
                                                      fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                      style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan2519">May</tspan>
                                                    <title>May</title></text>
                                                <text id="SvgjsText2521" font-family="Helvetica, Arial, sans-serif"
                                                      x="278.94166684150696" y="214.112" text-anchor="middle"
                                                      dominant-baseline="auto" font-size="12px" font-weight="400"
                                                      fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                      style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan2522">Jun</tspan>
                                                    <title>Jun</title></text>
                                                <text id="SvgjsText2524" font-family="Helvetica, Arial, sans-serif"
                                                      x="329.65833353996277" y="214.112" text-anchor="middle"
                                                      dominant-baseline="auto" font-size="12px" font-weight="400"
                                                      fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                      style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan2525">Jul</tspan>
                                                    <title>Jul</title></text>
                                                <text id="SvgjsText2527" font-family="Helvetica, Arial, sans-serif"
                                                      x="380.3750002384186" y="214.112" text-anchor="middle"
                                                      dominant-baseline="auto" font-size="12px" font-weight="400"
                                                      fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                      style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan2528">Aug</tspan>
                                                    <title>Aug</title></text>
                                                <text id="SvgjsText2530" font-family="Helvetica, Arial, sans-serif"
                                                      x="431.0916669368744" y="214.112" text-anchor="middle"
                                                      dominant-baseline="auto" font-size="12px" font-weight="400"
                                                      fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                      style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan2531">Sep</tspan>
                                                    <title>Sep</title></text>
                                                <text id="SvgjsText2533" font-family="Helvetica, Arial, sans-serif"
                                                      x="481.8083336353302" y="214.112" text-anchor="middle"
                                                      dominant-baseline="auto" font-size="12px" font-weight="400"
                                                      fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                      style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan2534">Oct</tspan>
                                                    <title>Oct</title></text>
                                                <text id="SvgjsText2536" font-family="Helvetica, Arial, sans-serif"
                                                      x="532.525000333786" y="214.112" text-anchor="middle"
                                                      dominant-baseline="auto" font-size="12px" font-weight="400"
                                                      fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                      style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan2537">Nov</tspan>
                                                    <title>Nov</title></text>
                                                <text id="SvgjsText2539" font-family="Helvetica, Arial, sans-serif"
                                                      x="583.2416670322418" y="214.112" text-anchor="middle"
                                                      dominant-baseline="auto" font-size="12px" font-weight="400"
                                                      fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                      style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan2540">Dec</tspan>
                                                    <title>Dec</title></text>
                                            </g>
                                        </g>
                                        <g id="SvgjsG2561" class="apexcharts-yaxis-annotations"></g>
                                        <g id="SvgjsG2562" class="apexcharts-xaxis-annotations"></g>
                                        <g id="SvgjsG2563" class="apexcharts-point-annotations"></g>
                                    </g>
                                </svg>
                                <div class="apexcharts-tooltip apexcharts-theme-light"
                                     style="left: 217.755px; top: 105.3px;">
                                    <div class="apexcharts-tooltip-title"
                                         style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">Apr
                                    </div>
                                    <div class="apexcharts-tooltip-series-group apexcharts-active"
                                         style="order: 1; display: flex;"><span class="apexcharts-tooltip-marker"
                                                                                style="background-color: rgb(114, 124, 245);"></span>
                                        <div class="apexcharts-tooltip-text"
                                             style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                            <div class="apexcharts-tooltip-y-group"><span
                                                    class="apexcharts-tooltip-text-y-label">Actual: </span><span
                                                    class="apexcharts-tooltip-text-y-value">$81k</span></div>
                                            <div class="apexcharts-tooltip-goals-group"><span
                                                    class="apexcharts-tooltip-text-goals-label"></span><span
                                                    class="apexcharts-tooltip-text-goals-value"></span></div>
                                            <div class="apexcharts-tooltip-z-group"><span
                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                    class="apexcharts-tooltip-text-z-value"></span></div>
                                        </div>
                                    </div>
                                    <div class="apexcharts-tooltip-series-group" style="order: 2; display: none;"><span
                                            class="apexcharts-tooltip-marker"
                                            style="background-color: rgb(114, 124, 245);"></span>
                                        <div class="apexcharts-tooltip-text"
                                             style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                            <div class="apexcharts-tooltip-y-group"><span
                                                    class="apexcharts-tooltip-text-y-label">Actual: </span><span
                                                    class="apexcharts-tooltip-text-y-value">$81k</span></div>
                                            <div class="apexcharts-tooltip-goals-group"><span
                                                    class="apexcharts-tooltip-text-goals-label"></span><span
                                                    class="apexcharts-tooltip-text-goals-value"></span></div>
                                            <div class="apexcharts-tooltip-z-group"><span
                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                    class="apexcharts-tooltip-text-z-value"></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                    <div class="apexcharts-yaxistooltip-text"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->

        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-12 order-lg-2 order-xl-1">
            <div class="card">
                <div class="d-flex card-header justify-content-between align-items-center">
                    <h4 class="header-title">Top Selling Products</h4>
                    <a href="javascript:void(0);" class="btn btn-sm btn-light">Export <i
                            class="mdi mdi-download ms-1"></i></a>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <tbody>
                            <tr>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">ASOS Ridley High Waist</h5>
                                    <span class="text-muted font-13">07 April 2018</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">$79.49</h5>
                                    <span class="text-muted font-13">Price</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">82</h5>
                                    <span class="text-muted font-13">Quantity</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">$6,518.18</h5>
                                    <span class="text-muted font-13">Amount</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">Marco Lightweight Shirt</h5>
                                    <span class="text-muted font-13">25 March 2018</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">$128.50</h5>
                                    <span class="text-muted font-13">Price</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">37</h5>
                                    <span class="text-muted font-13">Quantity</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">$4,754.50</h5>
                                    <span class="text-muted font-13">Amount</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">Half Sleeve Shirt</h5>
                                    <span class="text-muted font-13">17 March 2018</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">$39.99</h5>
                                    <span class="text-muted font-13">Price</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">64</h5>
                                    <span class="text-muted font-13">Quantity</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">$2,559.36</h5>
                                    <span class="text-muted font-13">Amount</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">Lightweight Jacket</h5>
                                    <span class="text-muted font-13">12 March 2018</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">$20.00</h5>
                                    <span class="text-muted font-13">Price</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">184</h5>
                                    <span class="text-muted font-13">Quantity</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">$3,680.00</h5>
                                    <span class="text-muted font-13">Amount</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">Marco Shoes</h5>
                                    <span class="text-muted font-13">05 March 2018</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">$28.49</h5>
                                    <span class="text-muted font-13">Price</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">69</h5>
                                    <span class="text-muted font-13">Quantity</span>
                                </td>
                                <td>
                                    <h5 class="font-14 my-1 fw-normal">$1,965.81</h5>
                                    <span class="text-muted font-13">Amount</span>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-3 col-lg-6 order-lg-1">
            <div class="card">
                <div class="d-flex card-header justify-content-between align-items-center">
                    <h4 class="header-title">Total Sales</h4>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div id="average-sales" class="apex-charts mb-4 mt-2" data-colors="#727cf5,#0acf97,#fa5c7c,#ffbc00"
                         style="min-height: 208.8px;">
                        <div id="apexcharts3n8wflf4" class="apexcharts-canvas apexcharts3n8wflf4 apexcharts-theme-light"
                             style="width: 237px; height: 208.8px;">
                            <svg id="SvgjsSvg3258" width="237" height="208.8" xmlns="http://www.w3.org/2000/svg"
                                 version="1.1"
                                 class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                 style="background: transparent;">
                                <foreignObject x="0" y="0" width="237" height="208.8">
                                    <div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml"></div>
                                </foreignObject>
                                <g id="SvgjsG3260" class="apexcharts-inner apexcharts-graphical"
                                   transform="translate(17.5, 0)">
                                    <defs id="SvgjsDefs3259">
                                        <clipPath id="gridRectMask3n8wflf4">
                                            <rect id="SvgjsRect3261" width="206" height="206" x="-2" y="-2" rx="0"
                                                  ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"
                                                  fill="#fff"></rect>
                                        </clipPath>
                                        <clipPath id="forecastMask3n8wflf4"></clipPath>
                                        <clipPath id="nonForecastMask3n8wflf4"></clipPath>
                                        <clipPath id="gridRectMarkerMask3n8wflf4">
                                            <rect id="SvgjsRect3262" width="206" height="206" x="-2" y="-2" rx="0"
                                                  ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"
                                                  fill="#fff"></rect>
                                        </clipPath>
                                        <filter id="SvgjsFilter3271" filterUnits="userSpaceOnUse" width="200%"
                                                height="200%" x="-50%" y="-50%">
                                            <feFlood id="SvgjsFeFlood3272" flood-color="#000000" flood-opacity="0.45"
                                                     result="SvgjsFeFlood3272Out" in="SourceGraphic"></feFlood>
                                            <feComposite id="SvgjsFeComposite3273" in="SvgjsFeFlood3272Out"
                                                         in2="SourceAlpha" operator="in"
                                                         result="SvgjsFeComposite3273Out"></feComposite>
                                            <feOffset id="SvgjsFeOffset3274" dx="1" dy="1" result="SvgjsFeOffset3274Out"
                                                      in="SvgjsFeComposite3273Out"></feOffset>
                                            <feGaussianBlur id="SvgjsFeGaussianBlur3275" stdDeviation="1 "
                                                            result="SvgjsFeGaussianBlur3275Out"
                                                            in="SvgjsFeOffset3274Out"></feGaussianBlur>
                                            <feMerge id="SvgjsFeMerge3276" result="SvgjsFeMerge3276Out"
                                                     in="SourceGraphic">
                                                <feMergeNode id="SvgjsFeMergeNode3277"
                                                             in="SvgjsFeGaussianBlur3275Out"></feMergeNode>
                                                <feMergeNode id="SvgjsFeMergeNode3278"
                                                             in="[object Arguments]"></feMergeNode>
                                            </feMerge>
                                            <feBlend id="SvgjsFeBlend3279" in="SourceGraphic" in2="SvgjsFeMerge3276Out"
                                                     mode="normal" result="SvgjsFeBlend3279Out"></feBlend>
                                        </filter>
                                        <filter id="SvgjsFilter3284" filterUnits="userSpaceOnUse" width="200%"
                                                height="200%" x="-50%" y="-50%">
                                            <feFlood id="SvgjsFeFlood3285" flood-color="#000000" flood-opacity="0.45"
                                                     result="SvgjsFeFlood3285Out" in="SourceGraphic"></feFlood>
                                            <feComposite id="SvgjsFeComposite3286" in="SvgjsFeFlood3285Out"
                                                         in2="SourceAlpha" operator="in"
                                                         result="SvgjsFeComposite3286Out"></feComposite>
                                            <feOffset id="SvgjsFeOffset3287" dx="1" dy="1" result="SvgjsFeOffset3287Out"
                                                      in="SvgjsFeComposite3286Out"></feOffset>
                                            <feGaussianBlur id="SvgjsFeGaussianBlur3288" stdDeviation="1 "
                                                            result="SvgjsFeGaussianBlur3288Out"
                                                            in="SvgjsFeOffset3287Out"></feGaussianBlur>
                                            <feMerge id="SvgjsFeMerge3289" result="SvgjsFeMerge3289Out"
                                                     in="SourceGraphic">
                                                <feMergeNode id="SvgjsFeMergeNode3290"
                                                             in="SvgjsFeGaussianBlur3288Out"></feMergeNode>
                                                <feMergeNode id="SvgjsFeMergeNode3291"
                                                             in="[object Arguments]"></feMergeNode>
                                            </feMerge>
                                            <feBlend id="SvgjsFeBlend3292" in="SourceGraphic" in2="SvgjsFeMerge3289Out"
                                                     mode="normal" result="SvgjsFeBlend3292Out"></feBlend>
                                        </filter>
                                        <filter id="SvgjsFilter3297" filterUnits="userSpaceOnUse" width="200%"
                                                height="200%" x="-50%" y="-50%">
                                            <feFlood id="SvgjsFeFlood3298" flood-color="#000000" flood-opacity="0.45"
                                                     result="SvgjsFeFlood3298Out" in="SourceGraphic"></feFlood>
                                            <feComposite id="SvgjsFeComposite3299" in="SvgjsFeFlood3298Out"
                                                         in2="SourceAlpha" operator="in"
                                                         result="SvgjsFeComposite3299Out"></feComposite>
                                            <feOffset id="SvgjsFeOffset3300" dx="1" dy="1" result="SvgjsFeOffset3300Out"
                                                      in="SvgjsFeComposite3299Out"></feOffset>
                                            <feGaussianBlur id="SvgjsFeGaussianBlur3301" stdDeviation="1 "
                                                            result="SvgjsFeGaussianBlur3301Out"
                                                            in="SvgjsFeOffset3300Out"></feGaussianBlur>
                                            <feMerge id="SvgjsFeMerge3302" result="SvgjsFeMerge3302Out"
                                                     in="SourceGraphic">
                                                <feMergeNode id="SvgjsFeMergeNode3303"
                                                             in="SvgjsFeGaussianBlur3301Out"></feMergeNode>
                                                <feMergeNode id="SvgjsFeMergeNode3304"
                                                             in="[object Arguments]"></feMergeNode>
                                            </feMerge>
                                            <feBlend id="SvgjsFeBlend3305" in="SourceGraphic" in2="SvgjsFeMerge3302Out"
                                                     mode="normal" result="SvgjsFeBlend3305Out"></feBlend>
                                        </filter>
                                        <filter id="SvgjsFilter3310" filterUnits="userSpaceOnUse" width="200%"
                                                height="200%" x="-50%" y="-50%">
                                            <feFlood id="SvgjsFeFlood3311" flood-color="#000000" flood-opacity="0.45"
                                                     result="SvgjsFeFlood3311Out" in="SourceGraphic"></feFlood>
                                            <feComposite id="SvgjsFeComposite3312" in="SvgjsFeFlood3311Out"
                                                         in2="SourceAlpha" operator="in"
                                                         result="SvgjsFeComposite3312Out"></feComposite>
                                            <feOffset id="SvgjsFeOffset3313" dx="1" dy="1" result="SvgjsFeOffset3313Out"
                                                      in="SvgjsFeComposite3312Out"></feOffset>
                                            <feGaussianBlur id="SvgjsFeGaussianBlur3314" stdDeviation="1 "
                                                            result="SvgjsFeGaussianBlur3314Out"
                                                            in="SvgjsFeOffset3313Out"></feGaussianBlur>
                                            <feMerge id="SvgjsFeMerge3315" result="SvgjsFeMerge3315Out"
                                                     in="SourceGraphic">
                                                <feMergeNode id="SvgjsFeMergeNode3316"
                                                             in="SvgjsFeGaussianBlur3314Out"></feMergeNode>
                                                <feMergeNode id="SvgjsFeMergeNode3317"
                                                             in="[object Arguments]"></feMergeNode>
                                            </feMerge>
                                            <feBlend id="SvgjsFeBlend3318" in="SourceGraphic" in2="SvgjsFeMerge3315Out"
                                                     mode="normal" result="SvgjsFeBlend3318Out"></feBlend>
                                        </filter>
                                    </defs>
                                    <g id="SvgjsG3263" class="apexcharts-pie">
                                        <g id="SvgjsG3264" transform="translate(0, 0) scale(1)">
                                            <circle id="SvgjsCircle3265" r="61.44878048780489" cx="101" cy="101"
                                                    fill="transparent"></circle>
                                            <g id="SvgjsG3266" class="apexcharts-slices">
                                                <g id="SvgjsG3267" class="apexcharts-series apexcharts-pie-series"
                                                   seriesName="Direct" rel="1" data:realIndex="0">
                                                    <path id="SvgjsPath3268"
                                                          d="M 101 6.463414634146332 A 94.53658536585367 94.53658536585367 0 0 1 193.83360616094376 118.8630215750337 L 161.34184400461345 112.6109640237719 A 61.44878048780489 61.44878048780489 0 0 0 101 39.55121951219511 L 101 6.463414634146332 z "
                                                          fill="rgba(114,124,245,1)" fill-opacity="1" stroke-opacity="1"
                                                          stroke-linecap="butt" stroke-width="0" stroke-dasharray="0"
                                                          class="apexcharts-pie-area apexcharts-donut-slice-0" index="0"
                                                          j="0" data:angle="100.89171974522293" data:startAngle="0"
                                                          data:strokeWidth="0" data:value="44"
                                                          data:pathOrig="M 101 6.463414634146332 A 94.53658536585367 94.53658536585367 0 0 1 193.83360616094376 118.8630215750337 L 161.34184400461345 112.6109640237719 A 61.44878048780489 61.44878048780489 0 0 0 101 39.55121951219511 L 101 6.463414634146332 z "></path>
                                                </g>
                                                <g id="SvgjsG3280" class="apexcharts-series apexcharts-pie-series"
                                                   seriesName="Affilliate" rel="2" data:realIndex="1">
                                                    <path id="SvgjsPath3281"
                                                          d="M 193.83360616094376 118.8630215750337 A 94.53658536585367 94.53658536585367 0 0 1 31.853151392789883 165.46610970368 L 56.05454840531342 142.902971307392 A 61.44878048780489 61.44878048780489 0 0 0 161.34184400461345 112.6109640237719 L 193.83360616094376 118.8630215750337 z "
                                                          fill="rgba(10,207,151,1)" fill-opacity="1" stroke-opacity="1"
                                                          stroke-linecap="butt" stroke-width="0" stroke-dasharray="0"
                                                          class="apexcharts-pie-area apexcharts-donut-slice-1" index="0"
                                                          j="1" data:angle="126.11464968152865"
                                                          data:startAngle="100.89171974522293" data:strokeWidth="0"
                                                          data:value="55"
                                                          data:pathOrig="M 193.83360616094376 118.8630215750337 A 94.53658536585367 94.53658536585367 0 0 1 31.853151392789883 165.46610970368 L 56.05454840531342 142.902971307392 A 61.44878048780489 61.44878048780489 0 0 0 161.34184400461345 112.6109640237719 L 193.83360616094376 118.8630215750337 z "></path>
                                                </g>
                                                <g id="SvgjsG3293" class="apexcharts-series apexcharts-pie-series"
                                                   seriesName="Sponsored" rel="3" data:realIndex="2">
                                                    <path id="SvgjsPath3294"
                                                          d="M 31.853151392789883 165.46610970368 A 94.53658536585367 94.53658536585367 0 0 1 41.53070443379898 27.511437233436368 L 62.344957881969336 53.23243420173364 A 61.44878048780489 61.44878048780489 0 0 0 56.05454840531342 142.902971307392 L 31.853151392789883 165.46610970368 z "
                                                          fill="rgba(250,92,124,1)" fill-opacity="1" stroke-opacity="1"
                                                          stroke-linecap="butt" stroke-width="0" stroke-dasharray="0"
                                                          class="apexcharts-pie-area apexcharts-donut-slice-2" index="0"
                                                          j="2" data:angle="94.01273885350315"
                                                          data:startAngle="227.00636942675158" data:strokeWidth="0"
                                                          data:value="41"
                                                          data:pathOrig="M 31.853151392789883 165.46610970368 A 94.53658536585367 94.53658536585367 0 0 1 41.53070443379898 27.511437233436368 L 62.344957881969336 53.23243420173364 A 61.44878048780489 61.44878048780489 0 0 0 56.05454840531342 142.902971307392 L 31.853151392789883 165.46610970368 z "></path>
                                                </g>
                                                <g id="SvgjsG3306" class="apexcharts-series apexcharts-pie-series"
                                                   seriesName="E-mail" rel="4" data:realIndex="3">
                                                    <path id="SvgjsPath3307"
                                                          d="M 41.53070443379898 27.511437233436368 A 94.53658536585367 94.53658536585367 0 0 1 100.98350025330149 6.463416074020856 L 100.98927516464596 39.551220448113554 A 61.44878048780489 61.44878048780489 0 0 0 62.344957881969336 53.23243420173364 L 41.53070443379898 27.511437233436368 z "
                                                          fill="rgba(255,188,0,1)" fill-opacity="1" stroke-opacity="1"
                                                          stroke-linecap="butt" stroke-width="0" stroke-dasharray="0"
                                                          class="apexcharts-pie-area apexcharts-donut-slice-3" index="0"
                                                          j="3" data:angle="38.980891719745216"
                                                          data:startAngle="321.0191082802547" data:strokeWidth="0"
                                                          data:value="17"
                                                          data:pathOrig="M 41.53070443379898 27.511437233436368 A 94.53658536585367 94.53658536585367 0 0 1 100.98350025330149 6.463416074020856 L 100.98927516464596 39.551220448113554 A 61.44878048780489 61.44878048780489 0 0 0 62.344957881969336 53.23243420173364 L 41.53070443379898 27.511437233436368 z "></path>
                                                </g>
                                                <g id="SvgjsG3269" class="apexcharts-datalabels">
                                                    <text id="SvgjsText3270" font-family="Helvetica, Arial, sans-serif"
                                                          x="161.13416747916162" y="51.33370869781931"
                                                          text-anchor="middle" dominant-baseline="auto" font-size="12px"
                                                          font-weight="600" fill="#ffffff"
                                                          class="apexcharts-text apexcharts-pie-label"
                                                          filter="url(#SvgjsFilter3271)"
                                                          style="font-family: Helvetica, Arial, sans-serif;">28.0%
                                                    </text>
                                                </g>
                                                <g id="SvgjsG3282" class="apexcharts-datalabels">
                                                    <text id="SvgjsText3283" font-family="Helvetica, Arial, sans-serif"
                                                          x="122.5643634115749" y="175.95223025886858"
                                                          text-anchor="middle" dominant-baseline="auto" font-size="12px"
                                                          font-weight="600" fill="#ffffff"
                                                          class="apexcharts-text apexcharts-pie-label"
                                                          filter="url(#SvgjsFilter3284)"
                                                          style="font-family: Helvetica, Arial, sans-serif;">35.0%
                                                    </text>
                                                </g>
                                                <g id="SvgjsG3295" class="apexcharts-datalabels">
                                                    <text id="SvgjsText3296" font-family="Helvetica, Arial, sans-serif"
                                                          x="23.198514863883616" y="95.54220733816429"
                                                          text-anchor="middle" dominant-baseline="auto" font-size="12px"
                                                          font-weight="600" fill="#ffffff"
                                                          class="apexcharts-text apexcharts-pie-label"
                                                          filter="url(#SvgjsFilter3297)"
                                                          style="font-family: Helvetica, Arial, sans-serif;">26.1%
                                                    </text>
                                                </g>
                                                <g id="SvgjsG3308" class="apexcharts-datalabels">
                                                    <text id="SvgjsText3309" font-family="Helvetica, Arial, sans-serif"
                                                          x="74.9777672356971" y="27.476520810795634"
                                                          text-anchor="middle" dominant-baseline="auto" font-size="12px"
                                                          font-weight="600" fill="#ffffff"
                                                          class="apexcharts-text apexcharts-pie-label"
                                                          filter="url(#SvgjsFilter3310)"
                                                          style="font-family: Helvetica, Arial, sans-serif;">10.8%
                                                    </text>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                    <line id="SvgjsLine3319" x1="0" y1="0" x2="202" y2="0" stroke="#b6b6b6"
                                          stroke-dasharray="0" stroke-width="1" stroke-linecap="butt"
                                          class="apexcharts-ycrosshairs"></line>
                                    <line id="SvgjsLine3320" x1="0" y1="0" x2="202" y2="0" stroke-dasharray="0"
                                          stroke-width="0" stroke-linecap="butt"
                                          class="apexcharts-ycrosshairs-hidden"></line>
                                </g>
                            </svg>
                            <div class="apexcharts-tooltip apexcharts-theme-dark">
                                <div class="apexcharts-tooltip-series-group" style="order: 1;"><span
                                        class="apexcharts-tooltip-marker"
                                        style="background-color: rgb(114, 124, 245);"></span>
                                    <div class="apexcharts-tooltip-text"
                                         style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-y-label"></span><span
                                                class="apexcharts-tooltip-text-y-value"></span></div>
                                        <div class="apexcharts-tooltip-goals-group"><span
                                                class="apexcharts-tooltip-text-goals-label"></span><span
                                                class="apexcharts-tooltip-text-goals-value"></span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                                <div class="apexcharts-tooltip-series-group" style="order: 2;"><span
                                        class="apexcharts-tooltip-marker"
                                        style="background-color: rgb(10, 207, 151);"></span>
                                    <div class="apexcharts-tooltip-text"
                                         style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-y-label"></span><span
                                                class="apexcharts-tooltip-text-y-value"></span></div>
                                        <div class="apexcharts-tooltip-goals-group"><span
                                                class="apexcharts-tooltip-text-goals-label"></span><span
                                                class="apexcharts-tooltip-text-goals-value"></span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                                <div class="apexcharts-tooltip-series-group" style="order: 3;"><span
                                        class="apexcharts-tooltip-marker"
                                        style="background-color: rgb(250, 92, 124);"></span>
                                    <div class="apexcharts-tooltip-text"
                                         style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-y-label"></span><span
                                                class="apexcharts-tooltip-text-y-value"></span></div>
                                        <div class="apexcharts-tooltip-goals-group"><span
                                                class="apexcharts-tooltip-text-goals-label"></span><span
                                                class="apexcharts-tooltip-text-goals-value"></span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                                <div class="apexcharts-tooltip-series-group" style="order: 4;"><span
                                        class="apexcharts-tooltip-marker"
                                        style="background-color: rgb(255, 188, 0);"></span>
                                    <div class="apexcharts-tooltip-text"
                                         style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-y-label"></span><span
                                                class="apexcharts-tooltip-text-y-value"></span></div>
                                        <div class="apexcharts-tooltip-goals-group"><span
                                                class="apexcharts-tooltip-text-goals-label"></span><span
                                                class="apexcharts-tooltip-text-goals-value"></span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="chart-widget-list">
                        <p>
                            <i class="mdi mdi-square text-primary"></i> Direct
                            <span class="float-end">$300.56</span>
                        </p>
                        <p>
                            <i class="mdi mdi-square text-danger"></i> Affilliate
                            <span class="float-end">$135.18</span>
                        </p>
                        <p>
                            <i class="mdi mdi-square text-success"></i> Sponsored
                            <span class="float-end">$48.96</span>
                        </p>
                        <p class="mb-0">
                            <i class="mdi mdi-square text-warning"></i> E-mail
                            <span class="float-end">$154.02</span>
                        </p>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-3 col-lg-6 order-lg-1">
            <div class="card">
                <div class="d-flex card-header justify-content-between align-items-center">
                    <h4 class="header-title">Recent Activity</h4>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        </div>
                    </div>
                </div>

                <div class="card-body py-0 mb-3 simplebar-scrollable-y" data-simplebar="init"
                     style="max-height: 403px;">
                    <div class="simplebar-wrapper" style="margin: 0px -24px;">
                        <div class="simplebar-height-auto-observer-wrapper">
                            <div class="simplebar-height-auto-observer"></div>
                        </div>
                        <div class="simplebar-mask">
                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                     aria-label="scrollable content" style="height: auto; overflow: hidden scroll;">
                                    <div class="simplebar-content" style="padding: 0px 24px;">
                                        <div class="timeline-alt py-0">
                                            <div class="timeline-item">
                                                <i class="mdi mdi-upload bg-info-lighten text-info timeline-icon"></i>
                                                <div class="timeline-item-info">
                                                    <a href="javascript:void(0);"
                                                       class="text-info fw-bold mb-1 d-block">You sold an item</a>
                                                    <small>Paul Burgess just purchased “Hyper - Admin
                                                        Dashboard”!</small>
                                                    <p class="mb-0 pb-2">
                                                        <small class="text-muted">5 minutes ago</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <i class="mdi mdi-airplane bg-primary-lighten text-primary timeline-icon"></i>
                                                <div class="timeline-item-info">
                                                    <a href="javascript:void(0);"
                                                       class="text-primary fw-bold mb-1 d-block">Product on the
                                                        Bootstrap Market</a>
                                                    <small>Dave Gamache added
                                                        <span class="fw-bold">Admin Dashboard</span>
                                                    </small>
                                                    <p class="mb-0 pb-2">
                                                        <small class="text-muted">30 minutes ago</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <i class="mdi mdi-microphone bg-info-lighten text-info timeline-icon"></i>
                                                <div class="timeline-item-info">
                                                    <a href="javascript:void(0);"
                                                       class="text-info fw-bold mb-1 d-block">Robert Delaney</a>
                                                    <small>Send you message
                                                        <span class="fw-bold">"Are you there?"</span>
                                                    </small>
                                                    <p class="mb-0 pb-2">
                                                        <small class="text-muted">2 hours ago</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <i class="mdi mdi-upload bg-primary-lighten text-primary timeline-icon"></i>
                                                <div class="timeline-item-info">
                                                    <a href="javascript:void(0);"
                                                       class="text-primary fw-bold mb-1 d-block">Audrey Tobey</a>
                                                    <small>Uploaded a photo
                                                        <span class="fw-bold">"Error.jpg"</span>
                                                    </small>
                                                    <p class="mb-0 pb-2">
                                                        <small class="text-muted">14 hours ago</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <i class="mdi mdi-upload bg-info-lighten text-info timeline-icon"></i>
                                                <div class="timeline-item-info">
                                                    <a href="javascript:void(0);"
                                                       class="text-info fw-bold mb-1 d-block">You sold an item</a>
                                                    <small>Paul Burgess just purchased “Hyper - Admin
                                                        Dashboard”!</small>
                                                    <p class="mb-0 pb-2">
                                                        <small class="text-muted">16 hours ago</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <i class="mdi mdi-airplane bg-primary-lighten text-primary timeline-icon"></i>
                                                <div class="timeline-item-info">
                                                    <a href="javascript:void(0);"
                                                       class="text-primary fw-bold mb-1 d-block">Product on the
                                                        Bootstrap Market</a>
                                                    <small>Dave Gamache added
                                                        <span class="fw-bold">Admin Dashboard</span>
                                                    </small>
                                                    <p class="mb-0 pb-2">
                                                        <small class="text-muted">22 hours ago</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <i class="mdi mdi-microphone bg-info-lighten text-info timeline-icon"></i>
                                                <div class="timeline-item-info">
                                                    <a href="javascript:void(0);"
                                                       class="text-info fw-bold mb-1 d-block">Robert Delaney</a>
                                                    <small>Send you message
                                                        <span class="fw-bold">"Are you there?"</span>
                                                    </small>
                                                    <p class="mb-0 pb-2">
                                                        <small class="text-muted">2 days ago</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end timeline -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="simplebar-placeholder" style="width: 285px; height: 709px;"></div>
                    </div>
                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                    </div>
                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                        <div class="simplebar-scrollbar"
                             style="height: 229px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                    </div>
                </div> <!-- end simplebar -->
            </div>
            <!-- end card-->
        </div>
        <!-- end col -->

    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 order-lg-2 order-xl-1">
            <div class="card">
                <div class="d-flex card-header justify-content-between align-items-center">
                    <h4 class="header-title">Recent Orders</h4>
                    <a href="javascript:void(0);" class="btn btn-sm btn-light">Export <i
                            class="mdi mdi-download ms-1"></i></a>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-nowrap table-hover mb-0">
                            <thead>
                            <tr>
                                <th style="width: 80px">OrderNo</th>
                                <th>Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">Total</th>

                                <th class="text-center">Status</th>
                                <th class="text-center">Order Date</th>
                                <th class="text-center">Total Items</th>
                                <th class="text-center">Delivered On</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="text-center">{{$order->id}}</td>
                                    <td class="text-center">{{$order->customer->name}}</td>
                                    <td class="text-center">{{$order->address->phone}}</td>
                                    <td class="text-center">{{$order->lineTotal()}}</td>
                                    <td class="text-center">{{$order->subtotal()}}</td>
                                    <td class="text-center">{{$order->status}}</td>
                                    <td class="text-center">{{$order->created_at}}</td>
                                    <td class="text-center">{{$order->totalCount()}}</td>
                                    <td>{{$order->delivered_date}}</td>
                                    <td class="text-center">
                                        <a href="{{route('admin.orderDetails', ['orderId' => $order->id])}}">
                                            <div class="d-flex view-icon">
                                                <div class="item eye">
                                                    <i class="icon-eye"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>
@endsection
