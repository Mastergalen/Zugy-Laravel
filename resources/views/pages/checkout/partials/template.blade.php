<?php $noindex = true; ?>
@section('title', 'Checkout')

@extends('layouts.default')

@section('css')
    @parent
    <style>
        .order-step {
            list-style: none;
            margin: 0;
            clear: both;
            display: inline-block;
            height: auto;
            padding: 0;
            margin-bottom: 30px;
            width: 100%;
        }

        .order-step li {
            display: inline-block;
            float: left;
            height: auto;
            margin: 0;
            min-height: 55px;
            padding: 0;
            width: 33.33%;
            width: calc(100% / 3);
        }

        .order-step li a {
            background: #EFF0F2;
            display: inline-block;
            font-size: 14px;
            height: 100%;
            line-height: normal;
            padding: 20px 0 0;
            text-align: center;
            vertical-align: middle;
            width: 100%;
            text-transform: uppercase;
            font-size: 13px;

            color: #34495E;
            text-decoration: none;
            outline: none!important;
        }

        .order-step li a i {
            border-radius: 0;
            display: block;
            font-size: 20px;
            height: auto;
            left: 0;
            line-height: 40px;
            margin-top: -20px;
            padding: 0;
            text-align: center;
            width: auto;
            float: none!important;
            background: rgba(0,0,0,0.05);
        }

        .order-step li a span {
            display: block;
            padding: 5px 0;
        }

        .order-step li.active a {
            position: relative;
            color: #fff;
            background: #34495e;
        }

        .order-step li.active a:after {
            border-top-color: #34495e!important;
            top: 100%;
            left: 50%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-color: rgba(136,183,213,0);
            border-width: 10px;
            margin-left: -10px;
        }
    </style>
@endsection