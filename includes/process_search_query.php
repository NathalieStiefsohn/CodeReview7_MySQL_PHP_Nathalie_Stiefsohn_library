<?php
	// sanitize user search input to prevent sql injection
	$search = trim($_GET['search']);
	$search = strip_tags($search);
	$search = htmlspecialchars($search);
	$res_book=mysql_query("SELECT 
		title, first_name, family_name, image, publishing_year, genre, age, available, books.id as books_id, authors.id as authors_id
		FROM books 
		JOIN authors ON books.FK_authors=authors.id
		JOIN genres ON books.FK_genres=genres.id
		JOIN age_recommendations ON books.FK_age_recommendations=age_recommendations.id 
		JOIN libraries ON books.FK_libraries=libraries.id
		LEFT JOIN books_tags ON books.id=books_tags.FK_books
		LEFT JOIN tags ON books_tags.FK_tags=tags.id
		WHERE title LIKE '%$search%'
		OR first_name LIKE '%$search%'
		OR family_name LIKE '%$search%'
		OR genre LIKE '%$search%'
		OR publishing_year LIKE '%$search%'
		OR tag LIKE '%$search%'
		
		GROUP BY books_id
		ORDER BY title ASC");
?>