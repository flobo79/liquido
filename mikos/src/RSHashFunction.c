#include "RSHashFunction.h"

unsigned int RSHash(char* str, unsigned int len)
{
   unsigned int b    = 378551;
   unsigned int a    = 63689;
   unsigned int hash = 0;
   unsigned int i    = 0;

   for(i = 0; i < len; str++, i++)
   {
      //printf("%u. Hash: %u A: %u Char: %u\n",i,hash,a,(*str));
      hash = hash * a + (*str);
      a *= b;
   }
   
   return (hash & 0x7FFFFFFF);
}
