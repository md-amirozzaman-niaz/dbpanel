<?php

/**
 * three table join
 * upazilas, districts, divisions
 * 
 * return 
 */
$data = 'join=upazilas:district_id:districts:id,districts:division_id:divisions:id&where=division_id:1,district_id:34&return_only=upazilas.name as upazila,districts.name as district,divisions.name as division,website';