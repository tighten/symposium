{{ Form::open(array('url' => URL::route('post-oauth-authorize', $params))) }}
{{ Form::submit('Approve', array('name' => 'approve', 'class' => 'btn bg-blue')) }}
{{ Form::submit('Deny', array('name' => 'deny', 'class' => 'btn bg-red')) }}
{{ Form::close() }}
