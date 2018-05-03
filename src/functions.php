<?php

namespace GromNaN\JsonCrunch;

function crunch($uncrunched)
{
  return array($uncrunched);
}

function uncrunch($crunched)
{
  return $crunched[0];
}
