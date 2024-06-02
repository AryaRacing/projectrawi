import 'package:flutter/material.dart';
import 'package:proyek_akhir/controller/session.dart';
import 'package:proyek_akhir/database.dart';
import 'package:proyek_akhir/login.dart';

class AboutScreen extends StatefulWidget {
  const AboutScreen({Key? key}) : super(key: key);

  @override
  _AboutScreenState createState() => _AboutScreenState();
}

class _AboutScreenState extends State<AboutScreen> {
  final _sessionManager = SessionManager();
  List<Map<String, dynamic>> _userInfoList = [];

  @override
  void initState() {
    super.initState();
    _loadUserInfo();
  }

  Future<void> _loadUserInfo() async {
    var userInfoList = await DatabaseLog().getAllUserInfo();
    setState(() {
      _userInfoList = userInfoList;
    });
  }

  void _logout(BuildContext context) {
    _sessionManager.clearSession();
    
    Navigator.of(context).pushAndRemoveUntil(
      MaterialPageRoute(builder: (context) => LoginScreen()),
      (Route<dynamic> route) => false,
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('About'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: ListView.builder(
          itemCount: _userInfoList.length,
          itemBuilder: (ctx, index) {
            return ListTile(
              title: Text('Username: ${_userInfoList[index]['username']}'),
              subtitle: Text('Password: ${_userInfoList[index]['password']}'),
            );
          },
        ),
      ),
      bottomNavigationBar: BottomAppBar(
        child: Padding(
          padding: const EdgeInsets.all(8.0),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.end,
            children: [
              IconButton(
                icon: const Icon(Icons.logout),
                onPressed: () {
                  _logout(context);
                },
              ),
            ],
          ),
        ),
      ),
    );
  }
}
