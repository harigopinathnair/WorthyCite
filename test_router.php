<?php
$pattern = 'projects/{project_id}/geo';
$regex = preg_replace('/\{([a-zA-Z_]+)\}/', '([^/]+)', $pattern);
$url = 'projects/1/geo';
if (preg_match('#^' . $regex . '$#', $url, $matches)) {
    echo "Match found!\n";
    print_r($matches);
} else {
    echo "Match failed.\nRegex: $regex\nURL: $url\n";
}
