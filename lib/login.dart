import 'package:flutter/material.dart';
import 'package:proyek_akhir/controller/session.dart';
import 'package:proyek_akhir/encryptdata.dart';
import 'package:proyek_akhir/view/places.dart';
import 'database.dart';
import 'register.dart';

class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _usernameController = TextEditingController();
  final _passwordController = TextEditingController();
  final _dbHelper = DatabaseLog();
  final _sessionManager = SessionManager();

  void _login() async {
    String username = _usernameController.text;
    String password = Encryption.hashPassword(_passwordController.text);

    var user = await _dbHelper.getUser(username, password);
    if (user != null) {
      // Simpan sesi login
      await _sessionManager.saveSession(username);

      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => PlaceSScreen()),
      );
    } else {
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(
        content: Text('Username dan Password Salah, Silahkan ke menu Register bila belum memiliki akun!'),
      ));
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Login'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            TextField(
              controller: _usernameController,
              decoration: InputDecoration(labelText: 'Username'),
              style: TextStyle(color: Colors.white),
            ),
            TextField(
              controller: _passwordController,
              decoration: InputDecoration(labelText: 'Password'),
              style: TextStyle(color: Colors.white),
              obscureText: true,
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: _login,
              child: Text('Login'),
            ),
            TextButton(
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => RegisterScreen()),
                );
              },
              child: Text('Register'),
            ),
          ],
        ),
      ),
    );
  }
}
