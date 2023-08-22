import 'dart:convert';
import 'package:flutter_api/model/data_model.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class AuthRepository {
  Future loginUser(String _email, String _password, String _device) async {
    String baseUrl = "http://10.0.2.2/api/auth/login";

    try {
      var response = await http.post(baseUrl, body: {
        'email': _email,
        'password': _password,
        'device_name': _device
      });
      var jsonResponse = json.decode(response.body);
      return LoginAuth.fromJson(jsonResponse);
    } catch (e) {
      return e;
    }
  }

  Future userLogout(String token) async {
    String baseUrl = "http://10.0.2.2/api/auth/logout";
    try {
      var response = await http.post(baseUrl, headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'applcation/json'
      });
      var resbody = json.decode(response.body);
      return Logout.fromJson(resbody);
    } catch (e) {
      return e;
    }
  }

  Future getData(String token) async {
    String baseUrl = "http://10.0.2.2/api/auth/me";

    try {
      var response = await http.get(baseUrl, headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'applcation/json'
      });
      var body = json.decode(response.body);
      return User.fromJson(body);
    } catch (e) {
      return e;
    }
  }

  Future hasToken() async {
    Future<SharedPreferences> _prefs = SharedPreferences.getInstance();
    final SharedPreferences local = await _prefs;
    String token = local.getString("token_sanctum");
    return token;
  }

  Future setLocalToken(String token) async {
    Future<SharedPreferences> _prefs = SharedPreferences.getInstance();
    final SharedPreferences local = await _prefs;
    local.setString("token_sanctum", token);
  }

  Future unsetLocalToken() async {
    Future<SharedPreferences> _prefs = SharedPreferences.getInstance();
    final SharedPreferences local = await _prefs;
    local.setString("token_sanctum", null);
  }
}
