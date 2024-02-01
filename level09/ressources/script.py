# str = "f4kmm6p|=�p�n��DB�Du{��"
# str2 = "f4kmm6p|=M-^B^?pM-^BnM-^CM-^BDBM-^CDu{^?M-^LM-^I$"
str = "f4kmm6p|=XXpXnXXDBXDu{XXX"
i = 0
new_str = ""
print(str)
# print(str2)
for char in str:
	print(f"Character '{char}' has decimal value {ord(char)}")
	if (char == 'X'):
		new_value = ord(char)
	else:
		new_value = ord(char) - i
	new_char = chr(new_value)
	new_str += new_char
	i += 1

print(new_str)
