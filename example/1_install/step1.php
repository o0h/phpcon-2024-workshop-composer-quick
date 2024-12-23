<?php

// 読み込むcomposer.lockのパス: __DIR__ . '/composer.lock'

/* === STEP-1 ココから === */
$lockData = json_decode(file_get_contents(__DIR__ . '/composer.lock'), true);


/* === STEP-1 ココまで === */
