<?php
$tokens = token_get_all(file_get_contents('storage/framework/views/cf474496abc28edaf03cd908ce5d2d6b.php'));
$stack = [];
$lines = [];
foreach ($tokens as $token) {
    if (is_array($token)) {
        if (in_array($token[0], [T_IF, T_FOREACH, T_FOR, T_WHILE, T_SWITCH])) {
            $stack[] = ['token' => token_name($token[0]), 'line' => $token[2]];
        }
        if (in_array($token[0], [T_ENDIF, T_ENDFOREACH, T_ENDFOR, T_ENDWHILE, T_ENDSWITCH])) {
            array_pop($stack);
        }
    } else {
        if ($token === '{') {
            $stack[] = ['token' => '{', 'line' => -1];
        }
        if ($token === '}') {
            $item = array_pop($stack);
            if ($item && $item['token'] !== '{') {
                echo "Mismatch: expected { to pop but got " . json_encode($item) . "\n";
            }
        }
    }
}
print_r($stack);
