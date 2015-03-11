COMPILER      = -cc -static
OPTIONS       = -std=c99 -pedantic -Wall -o
OPTIONS_LIBS  = -std=c99 -pedantic -Wall -c

all: RSHashFunction.o RSHash

RSHashFunction.o: RSHashFunction.c RSHashFunction.h
	$(COMPILER) $(OPTIONS_LIBS) RSHashFunction.c

RSHash: RSHashFunction.c RSHash.c
	$(COMPILER) $(OPTIONS) RSHash RSHash.c RSHashFunction.o

clean:
	rm -f core *.o *.bak *stackdump *#
