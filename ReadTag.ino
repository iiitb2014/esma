//ReadTag.ino
// Connect RFID pin to pin 8
#include <LiquidCrystal.h>

#include <SoftwareSerial.h>

char input[12];				
int count = 0;				

SoftwareSerial rfid(8,9);
LiquidCrystal lcd(12, 11, 5, 4, 3, 2);
void setup()
{  
  // Enable serial debug
  Serial.begin(9600);
  rfid.begin(9600);
  lcd.begin(20, 2);		
}
void loop()
{      
  if(rfid.available())// check serial data ( RFID reader)
  {
        lcd.clear();
    count = 0; // Reset the counter to zero
    /* Keep reading Byte by Byte from the Buffer till the RFID Reader Buffer is	empty 
     		   or till 12 Bytes (the ID size of our Tag) is read */
      while(rfid.available() && count < 12) 
    {
      input[count] = rfid.read(); // Read 1 Byte of data and store it in the input[] variable
      count++; // increment counter
      delay(5);
    }
    //Serial.println("I received: ");
    for(int i=0;i<10;i++)
      Serial.print(input[i]);
    //Serial.println();
  }
  if(Serial.available())// check serial data ( RFID reader)
  {
    delay(100);  //wait some time for the data to fully be read
    lcd.clear();
    while (Serial.available() > 0) {
      char c = Serial.read();
      lcd.write(c);
    }
    delay(3000);
  }
  lcd.clear();
}

