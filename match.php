<?php
$content = file_get_contents('storage/framework/views/cf474496abc28edaf03cd908ce5d2d6b.php');
$lines = explode("\n", $content);
$stack = [];
foreach($lines as $i => $line) {
    if (strpos($line, '<?php if') !== false) {
        $stack[] = $i + 1;
    }
    if (strpos($line, '<?php endif;') !== false) {
        array_pop($stack);
    }
}
print_r($stack);
