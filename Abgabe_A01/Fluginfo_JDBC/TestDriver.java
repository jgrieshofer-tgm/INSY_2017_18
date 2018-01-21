/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package database;

import java.sql.*;

public class TestDriver {

    public static void main(String[] args) {
        try{
            String connectionURL = "jdbc:mysql://localhost:3306/flightmanager?autoReconnect=true";
            Connection myCon = DriverManager.getConnection(connectionURL, "root", "Antonius12");
            Statement test = myCon.createStatement();
            
            ResultSet testSet = test.executeQuery("select * from passengers");
            
            while(testSet.next()){
                System.out.println("ID: "+testSet.getString("id") + ", " + "Vorname " + testSet.getString("firstname"));
            }
        }catch (Exception e){
            e.printStackTrace();
        }
    }
    
}
