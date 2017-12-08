<?php
include("nc.php");
session_unset ("investok");
session_unset ("investname");
header("Location: login.php");