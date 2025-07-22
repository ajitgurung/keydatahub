import android.os.Bundle;
import com.getcapacitor.BridgeActivity;
import android.view.WindowManager;

public class MainActivity extends BridgeActivity {
  @Override
  public void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);

    // 🟡 Hide status bar (URL bar look)
    getWindow().setFlags(
      WindowManager.LayoutParams.FLAG_FULLSCREEN,
      WindowManager.LayoutParams.FLAG_FULLSCREEN
    );
  }
}
