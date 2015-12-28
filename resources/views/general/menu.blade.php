<ul class="sidebar-menu">
  <li class="header">{!! Lang::get('general.nav-menu') !!}</li>
  <li {!! ((Request::is('dashboard/*') || Request::is('dashboard')) ? 'class="active"' : '') !!}>
    <a href="{!! URL::to('dashboard') !!}">
      <i class="fa fa-dashboard"></i> <span>{!! Lang::get('general.dashboard') !!}</span></i>
    </a>
  </li>
  <li {!! ((Request::is('timesheets/*') || Request::is('timesheets')) ? 'class="active"' : '') !!}>
    <a href="{!! URL::to('timesheets') !!}">
      <i class="fa fa-clock-o"></i> <span>{!! Lang::get('general.timesheets') !!}</span></i>
    </a>
  </li>
  <li class="treeview {!! ((Request::is('projects/*') || Request::is('projects')) || (Request::is('tasks/*') || Request::is('tasks')) || (Request::is('proposals/*') || Request::is('proposals')) ? 'active' : '') !!}">
    <a href="#">
      <i class="fa fa-suitcase"></i> <span>{!! Lang::get('general.projects') !!}</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <!-- <ul class="treeview-menu">
  
      <li {!! ((Request::is('proposals/*') || Request::is('proposals')) ? 'class="active"' : '') !!}>
        <a href="{!! URL::to('proposals') !!}">
          <i class="fa fa-briefcase"></i> <span>{!! Lang::get('general.proposals') !!}</span></i>
        </a>
      </li>
  
  
      <li {!! ((Request::is('projects/*') || Request::is('projects')) ? 'class="active"' : '') !!}>
        <a href="{!! URL::to('projects') !!}">
          <i class="fa fa-wrench"></i> <span>{!! Lang::get('general.projects') !!}</span></i>
        </a>
      </li>
  
  
      <li {!! ((Request::is('tasks/*') || Request::is('tasks')) ? 'class="active"' : '') !!}>
        <a href="{!! URL::to('tasks') !!}">
          <i class="fa fa-tasks"></i> <span>{!! Lang::get('general.tasks') !!}</span></i>
        </a>
      </li>
  
    </ul>
  </li> -->
  <li class="treeview {!! ((Request::is('clients/*') || Request::is('clients')) || (Request::is('client-groups/*') || Request::is('client-groups')) ? 'active' : '') !!}">
    <a href="#">
      <i class="fa fa-user-secret"></i> <span>{!! Lang::get('general.clients') !!}</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
  
      <li {!! ((Request::is('clients/*') || Request::is('clients')) ? 'class="active"' : '') !!}>
        <a href="{!! URL::to('clients') !!}"><i class="fa fa-user-secret"></i> {!! Lang::get('general.clients') !!}</a>
      </li>
  
  
      <li {!! ((Request::is('client-groups/*') || Request::is('client-groups')) ? 'class="active"' : '') !!}>
        <a href="{!! URL::to('client-groups') !!}"><i class="fa fa-compass"></i> {!! Lang::get('general.client-groups') !!}</a>
      </li>
  
    </ul>
  </li>
  <li class="treeview {!! ((Request::is('users/*') || Request::is('users')) || (Request::is('group-permissions/*') || Request::is('group-permissions')) || (Request::is('teams/*') || Request::is('teams')) ? 'active' : '') !!}">
    <a href="#">
      <i class="fa fa-user"></i> <span>{!! Lang::get('general.users') !!}</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
  
      <li {!! ((Request::is('users/*') || Request::is('users')) ? 'class="active"' : '') !!}>
        <a href="{!! URL::to('users') !!}"><i class="fa fa-user"></i> {!! Lang::get('general.users-list') !!}</a>
      </li>
  
  
      <li {!! ((Request::is('group-permissions/*') || Request::is('group-permissions')) ? 'class="active"' : '') !!}>
        <a href="{!! URL::to('group-permissions') !!}"><i class="fa fa-shield"></i> {!! Lang::get('general.group-permissions') !!}</a>
      </li>
  
  
      <li {!! ((Request::is('teams/*') || Request::is('teams')) ? 'class="active"' : '') !!}>
        <a href="{!! URL::to('teams') !!}"><i class="fa fa-group"></i> {!! Lang::get('general.teams') !!}</a>
      </li>
  
    </ul>
  </li>
  <li class="treeview {!! ((Request::is('users/*') || Request::is('users')) || (Request::is('group-permissions/*') || Request::is('group-permissions')) || (Request::is('teams/*') || Request::is('teams')) ? 'active' : '') !!}">
    <a href="#">
      <i class="fa fa-cog"></i> <span>{!! Lang::get('general.system') !!}</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
  
      <li {!! ((Request::is('users/*') || Request::is('users')) ? 'class="active"' : '') !!}>
        <a href="{!! URL::to('users') !!}"><i class="fa fa-server"></i> {!! Lang::get('general.main') !!}</a>
      </li>
  
  
      <li {!! ((Request::is('group-permissions/*') || Request::is('group-permissions')) ? 'class="active"' : '') !!}>
        <a href="{!! URL::to('group-permissions') !!}"><i class="fa fa-bolt"></i> {!! Lang::get('general.modules') !!}</a>
      </li>
  
  
      <li {!! ((Request::is('teams/*') || Request::is('teams')) ? 'class="active"' : '') !!}>
        <a href="{!! URL::to('teams') !!}"><i class="fa fa-cloud"></i> {!! Lang::get('general.teams') !!}</a>
      </li>
  
    </ul>
  </li>
</ul>