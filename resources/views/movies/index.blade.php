<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<table border="1">
	<thead>
		<tr>
			<th>Movie</th>
		</tr>
	</thead>
	<tbody>
		@foreach($movies as $movie)
		<tr>
			<td>{{ $movie->title }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
</body>
</html>