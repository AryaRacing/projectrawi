import 'package:shared_preferences/shared_preferences.dart';

class SessionManager {
  // Key untuk menyimpan token atau data sesi
  static const String _sessionKey = 'session_key';

  // Fungsi untuk menyimpan data sesi
  Future<void> saveSession(String sessionData) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString(_sessionKey, sessionData);
  }

  // Fungsi untuk mengambil data sesi
  Future<String?> getSession() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString(_sessionKey);
  }

  // Fungsi untuk menghapus data sesi
  Future<void> clearSession() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove(_sessionKey);
  }
}
