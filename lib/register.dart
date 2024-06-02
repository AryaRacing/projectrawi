import 'package:flutter/material.dart';
import 'package:proyek_akhir/database.dart';
import 'package:proyek_akhir/encryptdata.dart';
import 'package:proyek_akhir/login.dart';

class RegisterScreen extends StatefulWidget {
  @override
  _RegisterScreenState createState() => _RegisterScreenState();
}

class _RegisterScreenState extends State<RegisterScreen> {
  final _usernameController = TextEditingController();
  final _passwordController = TextEditingController();
  final _dbHelper = DatabaseLog();

  void _register() async {
    String username = _usernameController.text;
    String password = Encryption.hashPassword(_passwordController.text);

    // Simpan pengguna baru ke database
    await _dbHelper.insertUser({'username': username, 'password': password});

    // Tampilkan pesan sukses dan navigasi ke halaman login
    ScaffoldMessenger.of(context).showSnackBar(SnackBar(
      content: Text('Registrasi berhasil, silakan login!'),
    ));

    Navigator.pushReplacement(
      context,
      MaterialPageRoute(builder: (context) => LoginScreen()),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Register'),
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
              onPressed: _register,
              child: Text('Register'),
            ),
          ],
        ),
      ),
    );
  }
}
