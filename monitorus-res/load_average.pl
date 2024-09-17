#!/usr/bin/perl

use strict;

# Данный скрипт выводит среднюю нагрузку сервера за 15 минут (параметр Load Average).

my $res=`uptime`;
my @res_array=split(/ /,$res);
$res_array[$#res_array]=~s/[\r\n]//g;
print "Content-type: text/plain\n\n";
print $res_array[$#res_array];
