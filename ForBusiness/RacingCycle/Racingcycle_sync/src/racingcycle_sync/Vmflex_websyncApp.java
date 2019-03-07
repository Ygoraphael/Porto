/*
 * Vmflex_websyncApp.java
 */

package racingcycle_sync;

import org.jdesktop.application.Application;
import org.jdesktop.application.SingleFrameApplication;

/**
 * The main class of the application.
 */
public class Vmflex_websyncApp extends SingleFrameApplication {

    @Override protected void startup() {
        show(new Vmflex_websyncView(this));
    }

    @Override protected void configureWindow(java.awt.Window root) {
    }

    public static Vmflex_websyncApp getApplication() {
        return Application.getInstance(Vmflex_websyncApp.class);
    }

    public static void main(String[] args) {
        launch(Vmflex_websyncApp.class, args);
    }
}
