<h1>{!! utf8_encode(strftime('%d de %B de %Y', strtotime($data['workday']->workday))) !!} </h1>
<ul class="timeline timeline-inverse">
  {{--*/ $project_id = null /*--}}
  {{--*/ $change = 1 /*--}}
  @foreach ($data['tasks'] as $task)
  @if ($project_id != $task->project_id)
  {{--*/ $project_id = $task->project_id /*--}}
  {{--*/ $change = 1 /*--}}
  @else
  {{--*/ $change = 0 /*--}}
  @endif
  @if ($change == 1)
  <!-- timeline time label -->
  <li class="time-label">
    <span class="{!! GeneralHelper::getBgStatus($task->getProject()->first()->status) !!}">
      {!! $task->getProject()->first()->name !!}
    </span>
  </li>
  <!-- /.timeline-label -->
  @endif
  <!-- timeline item -->
  <li>
    <i class="fa fa-tasks bg-blue"></i>

    <div class="timeline-item">
      <span class="time"><i class="fa fa-clock-o"></i> {!! GeneralHelper::withoutSeconds($task->start) . ' - ' . ($task->end != '00:00:00' && $task->hours != '00:00:00' ? GeneralHelper::withoutSeconds($task->end) : 'Atuando') !!}</span>

      <h3 class="timeline-header">{!! $task->getTask()->first()->subject !!}</h3>

      <div class="timeline-body">
        {!! $task->getTask()->first()->description !!}
      </div>
      {{-- <div class="timeline-footer">
        <a class="btn btn-primary btn-xs">Read more</a>
        <a class="btn btn-danger btn-xs">Delete</a>
      </div> --}}
    </div>
  </li>
  @endforeach
  <!-- END timeline item -->
  <li>
    <i class="fa fa-clock-o bg-gray"></i>
  </li>
</ul>