<?php
use App\User;

if (!function_exists('admin_counts'))
{
    function admin_counts()
    {
        return User::role('admin')->count();
    }
}
if (!function_exists('subscriber_counts'))
{
    function subscriber_counts()
    {
        return User::role('subscriber')->count();
    }
}

if (!function_exists('active_subscriber_counts'))
{
    function active_subscriber_counts()
    {
        return User::role('subscriber')->where('admin_approval', '1')->count();
    }
}

if (!function_exists('inactive_subscriber_counts'))
{
    function inactive_subscriber_counts()
    {
        return User::role('subscriber')->where('admin_approval', '0')->count();
    }
}