

#include <stdio.h>
#include <string.h>


int main(int ac, char **av) {
    int i = 0;
	char *str = {"f4kmm6p|=�p�n��DB�Du{��"};
    while (i < strlen(str)) {
        printf("%c", (char)(str[i] - i));
        i++;
    }
    printf("\n");

    return 0;
}
