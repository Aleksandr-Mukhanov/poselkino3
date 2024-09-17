#!/usr/bin/perl

use strict;

# Данный скрипт выводит количество дней работы сервера без перезагрузки.

my $res=`uptime`;
print "Content-type: text/plain\n\n";
if ($res=~/([0-9]+) day/i) {
	print $1;
}
else {
	print '0';
}
