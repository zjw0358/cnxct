#!/usr/bin/python
#-*- encoding:UTF-8 -*-
###
## @package
##
## @author      CFC4N   <cfc4nphp@gmail.com>
## @copyright   copyright (c) Www.cnxct.Com
## @Version     $Id$
###
import os
import sys
import re
import time
def listdir(dirs,liston='0'):
	flog = open(os.getcwd()+"/check_php_shell.log","a+")
	if not os.path.isdir(dirs):
		print "directory %s is not exist"% (dirs)
		return
	lists = os.listdir(dirs)
	for list in lists:
		filepath = os.path.join(dirs,list)
		if os.path.isdir(filepath):
			if liston == '1':
				listdir(filepath,'1')
		elif os.path.isfile(filepath):
			filename = os.path.basename(filepath)
			if re.search(r"\.(?:php|inc|html?)$", filename, re.IGNORECASE):
				i = 0
				iname = 0
				f = open(filepath)
				while f:
					file_contents = f.readline()
					if not file_contents:
						break
					i += 1
					match = re.search(r'''(?P<function>\b(?:include|require)(?:_once)?\b)\s*\(?\s*["'](?P<filename>[^;]*(?<!\.(?:php|inc)))["']\)?\s*;''', file_contents, re.IGNORECASE| re.MULTILINE)
					if match:
						function = match.group("function")
						filename = match.group("filename")
						if iname == 0:
							info = '\n[%s] :\n'% (filepath)
						else:
							info = ''
						info += '\t|-- [%s] - [%s]  line [%d] \n'% (function,filename,i)
						flog.write(info)
						print info
						iname += 1
					match = re.search(r'\b(?P<function>eval|proc_open|popen|shell_exec|exec|passthru|system|assert)\b\s*\(', file_contents, re.IGNORECASE| re.MULTILINE)
					if match:
						function = match.group("function")
						if iname == 0:
							info = '\n[%s] :\n'% (filepath)
						else:
							info = ''
						info += '\t|-- [%s]  line [%d] \n'% (function,i)
						flog.write(info)
						print info
						iname += 1
					match = re.search(r'(^|(?<=;))\s*`(?P<shell>[^`]+)`\s*;', file_contents, re.IGNORECASE)
					if match:
						shell = match.group("shell")
						if iname == 0:
							info = '\n[%s] :\n'% (filepath)
						else:
							info = ''
						info += '\t|-- [``] command is [%s] in line [%d] \n'% (shell,i)
						flog.write(info)
						print info
						iname += 1
					match = re.search(r'(?P<shell>\$_(?:POS|GE|REQUES)T)\s*\[[^\]]+\]\s*\(', file_contents, re.IGNORECASE)
					if match:
						shell = match.group("shell")
						if iname == 0:
							info = '\n[%s] :\n'% (filepath)
						else:
							info = ''
						info += '\t|-- [``] command is [%s] in line [%d] \n'% (shell,i)
						flog.write(info)
						print info
						iname += 1
				f.close()
	flog.close()
if '__main__' == __name__:
	argvnum = len(sys.argv)
	liston = '0'
	if argvnum == 1:
		action = os.path.basename(sys.argv[0])
		print "Command is like:\n	%s D:\wwwroot\ \n	%s D:\wwwroot\ 1	-- recurse subfolders"% (action,action)
		quit()
	elif argvnum == 2:
		path = os.path.realpath(sys.argv[1])
		listdir(path,liston)
	else:
		liston = sys.argv[2]
		path = os.path.realpath(sys.argv[1])
		listdir(path,liston)
	flog = open(os.getcwd()+"/check_php_shell.log","a+")
	ISOTIMEFORMAT='%Y-%m-%d %X'
	now_time = time.strftime(ISOTIMEFORMAT,time.localtime())
	flog.write("\n----------------------%s checked ---------------------\n"% (now_time))
	flog.close()
