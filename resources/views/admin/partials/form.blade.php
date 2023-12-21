@if($type == 'edit')
	<form action="{{ route($element.'.update', $id) }}" autocomplete="off" method="POST">
		@method('PUT')
@else
	<form action="{{ route($element.'.store') }}" autocomplete="off" method="POST">
		@method('POST')
@endif
	@csrf