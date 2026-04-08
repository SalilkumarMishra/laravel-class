<h1>Students Details</h1>
<hr>
@foreach($students as $student)
<p>Id: {{ $student['id']}}</p>
<p>Name: {{ $student['name']}}</p>
<p>Course: {{ $student['course']}}</p>
@endforeach