from unidecode import unidecode

# Your encrypted string
encrypted_string = "f4kmm6p|=M-^B^?pM-^BnM-^CM-^BDBM-^CDu{^?M-^LM-^I$"

# Convert symbolic representations to ASCII characters
decoded_string = unidecode(encrypted_string)

print(decoded_string)

print(encrypted_string.decode('utf-8'))

