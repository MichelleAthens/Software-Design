def check(x,y,z):
 if x=="+":
  return y-z
 elif x=="*":
  return y*z
 elif x=="-":
  return y-z
 else:
  return "invalid"



solution = check("-",2,2)

print (solution)