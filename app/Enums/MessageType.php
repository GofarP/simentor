<?php
namespace App\Enums;
enum MessageType:string{
    case All='all';
    case Sent='sent';
    case Received='received';
}