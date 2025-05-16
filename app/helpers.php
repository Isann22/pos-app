<?php

if (!function_exists('format_currency')) {
  function format_currency($amount)
  {
    return 'Rp ' . number_format($amount, 2, ',', '.');
  }
}
