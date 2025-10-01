<?php
namespace App\Enums;
enum InstructionType:string{
    case All='all';
    case Sent='sent';
    case Received='received';
}