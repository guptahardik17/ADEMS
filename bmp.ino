#include <SFE_BMP180.h>
#include <Wire.h>

SFE_BMP180 pressure;

void setup() {
  Serial.begin(9600);
  if (pressure.begin())
    Serial.println("BMP180 init success");
  else
  {
    Serial.println("BMP180 init fail\n\n");
  }
}

void loop()
{
  char status;
  double T, P;

  status = pressure.startPressure(3);
  if (status != 0)
  {
    delay(status);
    status = pressure.getPressure(P, T);
    if (status != 0)
    {
      Serial.print("");
      Serial.print(P, 2);
      Serial.println(" mb");
    }
    else Serial.println("Pressure retrieve error\n");
  }
  else Serial.println("Pressure start error\n");
  delay(500);
}

void bmpLoop()
{
  
}

