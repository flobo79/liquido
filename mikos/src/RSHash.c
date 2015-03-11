#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "RSHashFunction.h"

int main(int argc, char* argv[])
{
    if(argc == 2)
    {
	char* key = argv[1];

	//printf("Key: %s Length: %u\n",key,strlen(key));
	printf("%u\n",RSHash(key,strlen(key)));

	exit(EXIT_SUCCESS);
    }
    else
    {
	printf("error: no string given\n");
	return 1;
    }
}
