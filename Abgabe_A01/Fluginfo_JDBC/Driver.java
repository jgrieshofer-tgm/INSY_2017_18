/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package database;

import java.sql.*;
import java.util.ArrayList;
import java.util.TreeMap;

/**
 *
 * @author Babo
 */
public class Driver {

    private Frame f;
    private Statement flightmanager;
    private String user, pass;
    private Connection myCon;
    private static String connectionURL = "jdbc:mysql://localhost:3306/flightmanager?autoReconnect=true&useSSL=false";

    public Driver() throws SQLException {
        f = new Frame(this, myCon);
    }

    public boolean saveData(String user, String pass) {
        try {
            Connection myCon = DriverManager.getConnection(connectionURL, user, pass);
            this.user = user;
            this.pass = pass;
            myCon.close();
        } catch (Exception e) {
            e.printStackTrace();
            return false;
        }
        return true;
    }
    public String getPass(){
        return pass;
    }
    public String getUser(){
        return user;
    }
    public static void main(String[] args) throws SQLException {
        Driver d = new Driver();
    }
}
