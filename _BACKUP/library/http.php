<?php

function jumpToPage($page) {

		header('Location: /' . $page);
		exit();
}