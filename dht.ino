#include <dht.h>

#include <SoftwareSerial.h>

String temp , hum;

int DHpin = 8;
byte dat [5];

void setup() {
  Serial.begin(9600);  
  pinMode (DHpin, OUTPUT);
}

byte read_data () {
  byte data;
  for (int i = 0; i < 8; i ++) {
    if (digitalRead (DHpin) == LOW) {
      while (digitalRead (DHpin) == LOW); // wait for 50microseconds
      delayMicroseconds (30); // determine the duration of the high level to determine the data is '0 'or '1'
      if (digitalRead (DHpin) == HIGH)
        data |= (1 << (7 - i)); // high front and low in the post
      while (digitalRead (DHpin) == HIGH);
    }
  } return data;
}

void start_test () {
  digitalWrite (DHpin, LOW); // bus down, send start signal
  delay (30); // delay greater than 18ms, so DHT11 start signal can be detected
  digitalWrite (DHpin, HIGH);
  delayMicroseconds (40); // Wait for DHT11 response
  pinMode (DHpin, INPUT);
  while (digitalRead (DHpin) == HIGH);
  delayMicroseconds (80);
  
  if (digitalRead (DHpin) == LOW);
  delayMicroseconds (80);
  
  for (int i = 0; i < 4; i ++)
    dat[i] = read_data ();

  pinMode (DHpin, OUTPUT);
  digitalWrite (DHpin, HIGH);
}

void loop () {
  start_test ();
  hum = String(dat[0]);
  temp = String(dat[2]);
  Serial.println("temp = " + temp + "   humi = " + hum);
  delay(1000);
}
