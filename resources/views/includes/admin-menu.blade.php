<ul class="nav nav-tabs">
    <li <?php if(Request::is('admin/dashboard')) echo 'class="active"' ?>><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li <?php if(Request::is('admin/patients')) echo 'class="active"' ?>><a href="/admin/patients"><i class="fa fa-users"></i> Patients</a></li>
    <li <?php if(Request::is('admin/consultants')) echo 'class="active"' ?>><a href="/admin/consultants"><i class="fa fa-user-md"></i> Consultants</a></li>
    <li <?php if(Request::is('admin/admins')) echo 'class="active"' ?>><a href="/admin/admins"><i class="fa fa-lock"></i> Admins</a></li>
    
    
    <li class="pull-right">
        {!! Form::open(['action' => 'PatientController@index','method' => 'GET', 'class' => 'navbar-form', 'style' => 'margin-bottom: 0px']) !!}
            <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control" name="s" placeholder="Search patients">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i> Search</button>
                    </span>
                </div>
            </div>
        {!! Form::close() !!}
    </li>
</ul>